<!doctype html>
<?php
session_name('auth');
session_start();

require_once 'inc/db.php';
require_once 'inc/auth_check.php';
require_once 'inc/filter.php';

/*Pagination Start*/
$page = (isset($_GET['page']) ? (int)$_GET['page'] : 1);
$perPage = (isset($_GET['per-page']) && (int)$_GET['per-page'] <= 50 ? (int)$_GET['per-page'] : 5);
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

$sql = "SELECT * FROM info LIMIT ".$start.", ".$perPage." ";
$total = $db->query("SELECT * FROM info")->rowCount();
$pages = ceil($total / $perPage);

$stmt = $db->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*Pagination Ends*/

/*Delete Customer Information*/
if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    $stmt = $db->prepare('DELETE FROM info WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: dashboard.php');
}

?>
<html lang="en">
<head>
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>

<?php require_once 'inc/nav.php' ?>
<div class="container">
    <h2 class="text-center">View Customer Information</h2>
    <hr>
    <div class="col-12">
        <div class="text-center">
            <form action="search.php" class="form-group" method="post">
                <input type="text" class="form-control" name="search" placeholder="Enter Customer Contact">
            </form>

            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Contact</th>
                    <th scope="col">Name</th>
                    <th scope="col">Order No.</th>
                    <th scope="col">Issue Date</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($rows as $row): ?>
                <tr>
                    <th scope="row"><?php echo XSS($row['contact']) ?></th>
                    <td><?php echo XSS($row['name']) ?></td>
                    <td><?php echo XSS($row['order_no']) ?></td>
                    <td><?php echo XSS($row['issue_date']) ?></td>
                    <td>
                        <a href="add_info.php?id=<?php echo $row['id'] ?>" role="button" class="btn btn-primary">Edit</a>
                        <a href="dashboard.php?id=<?php echo $row['id'] ?>" role="button" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <nav class="offset-md-5">
                <ul class="pagination">
                    <?php for($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item"><a class="page-link <?php if($_GET['page']==$i) echo 'text-success'?>" href="?page=<?php echo $i;?>&per-page=<?php echo $perPage;?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>