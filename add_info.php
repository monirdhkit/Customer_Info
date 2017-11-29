<!doctype html>
<?php
session_name('auth');
session_start();

require_once 'inc/db.php';
require_once 'inc/auth_check.php';
require_once 'inc/filter.php';

/*Add Customer Information*/
if(isset($_POST['submit'])){
    $contact = XSS($_POST['contact']);
    $name = XSS($_POST['name']);
    $order_no = XSS($_POST['order_no']);

    $stmt = $db->prepare("INSERT INTO info (contact,name,order_no) VALUES(:contact, :name, :order_no)");
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':order_no', $order_no);
    $success=$stmt->execute();
}

/*Extract Customer Information*/
if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    $sql = "SELECT * FROM info WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

/*Update Customer Information*/
if(isset($_POST['update'])){
    $id = (int)$_POST['id'];
    $contact = XSS($_POST['contact']);
    $name = XSS($_POST['name']);
    $order_no = XSS($_POST['order_no']);

    $sql = "UPDATE info SET contact=:contact, name=:name, order_no=:order_no WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':order_no', $order_no);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: dashboard.php');
}

?>

<html lang="en">
<head>
    <title>New Customer</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
<?php require_once 'inc/nav.php' ?>
<div class="container">
    <h2 class="text-center">Add Customer Information</h2>
    <hr>
    <div class="col-12 col-sm-12 col-md-10 col-lg-8 mt-2 offset-md-2">

        <?php if(isset($_POST['submit']) && $success):?>
            <div class="alert alert-success" role="alert">Successfully Added Customer Information </div>
        <?php elseif(isset($_POST['submit']) && !$success):?>
            <div class="alert alert-warning" role="alert">Warning: Duplicate order number not allowed. </div>
        <?php endif;?>

        <form method="post" action="add_info.php">
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact" class="form-control" id="contact" placeholder="Customer Contact" autofocus required value="<?php echo (isset($_GET['id'])) ? XSS($row['contact']) : ''?>">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name"  placeholder="Customer Name" required value="<?php echo (isset($_GET['id'])) ? XSS($row['name']) : ''?>">
            </div>
            <div class="form-group">
                <label for="order_no">Order No.</label>
                <input type="text" name="order_no" class="form-control" id="order_no" placeholder="Order No." required value="<?php echo (isset($_GET['id'])) ? XSS($row['order_no']) : ''?>">
            </div>

            <div class="form-group">
                <input type="hidden" name="id" class="form-control" value="<?php echo (isset($_GET['id'])) ? (int)($row['id']) : '' ?>">
            </div>

            <div class="form-group text-center">
                <button type="submit" name="<?php echo (isset($_GET['id'])) ? 'update' : 'submit' ?>" class="btn btn-primary"?><?php echo (isset($_GET['id'])) ? 'Update' : "Submit" ?></button>
                <a href="dashboard.php" role="button" class="btn btn-info">Back</a>
            </div>
        </form>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>