<!doctype html>
<?php
session_name('auth');
session_start();

require_once 'inc/db.php';
require_once 'inc/auth_check.php';
require_once 'inc/filter.php';

/*Store errors in an array*/
$errors = array();

if(isset($_POST['search'])) {
    $search = XSS($_POST['search']);
    if(!empty($search)) {
        $search = '%' . $search . '%';

        $sql = "SELECT * FROM info WHERE contact LIKE :search";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':search', $search);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $errors[1] = "Found Nothing !!!";
        }
    }
    else{
        $errors[0] = "Search can not be empty";
    }
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
    <h2 class="text-center">Search Customer Information</h2>
    <hr>
    <div class="col-12">
        <div class="text-center">
            <form action="search.php" name="search" class="form-group" method="post">
                <input type="text" class="form-control" name="search" placeholder="Enter Customer Contact">

                <?php if(isset($_POST['search'])&&$errors != null) :?>
                   <ul class="col-12 mt-2">
                     <div class="alert alert-warning" role="alert">
                       <?php foreach($errors as $error): ?>
                           <li style="list-style-type: none"><?php echo $error; ?></li>
                       <?php endforeach; ?>
                     </div>
                   </ul>
                <?php endif; ?>

            </form>

            <?php if((isset($_POST['search']) && $errors==null)) :?>

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
            <?php endif; ?>

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