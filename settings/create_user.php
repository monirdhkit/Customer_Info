<!doctype html>
<?php
session_name('auth');
session_start();

require_once '../inc/db.php';
require_once '../inc/filter.php';

/*Check Authentication*/
if(!isset($_SESSION['admin']['login']) && !isset($_SESSION['user']['login'])){
    header('Location: ../index.php');
}

/*Create New User*/
if(isset($_POST['create_user'])){

    $user_email = valid_email($_POST['user_email']);
    $user_email = sanitize_email($user_email);
    $user_name = XSS($_POST['user_name']);
    $user_password = $_POST['user_password'];
    $user_password = password_hash($user_password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (user_email,user_name,user_password,user_type) VALUES(:user_email,:user_name,:user_password,:user_type)");
    $stmt->bindParam(':user_email', $user_email);
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':user_password', $user_password);
    $stmt->bindValue(':user_type', 'user');
    $success=$stmt->execute();
    header('Location: settings.php?page=users');
}
?>
<html lang="en">
<head>
    <title>Create User</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>

<?php require_once 'pages/nav.php' ?>

<div class="container">
    <h2 class="text-center">Create New User</h2>
    <hr>
    <div class="col-12 col-sm-12 col-md-10 col-lg-8 mt-2 offset-md-2">

        <form method="post" action="create_user.php">
            <div class="form-group">
                <label for="email">User E-mail</label>
                <input type="text" name="user_email" class="form-control" id="email"  placeholder="Enter user e-mail" required>
            </div>
            <div class="form-group">
                <label for="name">User Name</label>
                <input type="text" name="user_name" class="form-control" id="name" placeholder="Enter user name" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" name="user_password" class="form-control" id="password" placeholder="Enter user password" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" name="create_user" class="btn btn-primary"?>Create</button>
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