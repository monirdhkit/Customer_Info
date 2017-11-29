<!doctype html>
<?php
session_name('auth');
session_start();

require_once '../inc/db.php';
require_once '../inc/filter.php';

/*Check Authentication*/
/*Only Admin can access setting page*/
if(!isset($_SESSION['admin']['login'])){
    header('Location: ../index.php');
}

/*Extract Admin Information */
$stmt = $db->prepare("SELECT * FROM users WHERE user_type=:user_type");
$stmt->bindValue(':user_type', 'admin');
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

/*Update Admin username and email*/
if(isset($_POST['update'])){
    $password = $_POST['verify_password'];

    if(password_verify($password, $row['user_password'])) {
        $admin_id = $_POST['admin_id'];
        $admin_email = $_POST['admin_email'];
        $admin_name = $_POST['admin_name'];

        $sql = "UPDATE users SET user_email=:admin_email, user_name=:admin_name WHERE user_id=:admin_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':admin_email', $admin_email);
        $stmt->bindParam(':admin_name', $admin_name);
        $stmt->bindParam(':admin_id', $admin_id);
        $stmt->execute();

        if($stmt->rowCount()) {
            header('Location: settings.php?status=success');
        }
    }
    else{
        header('Location: settings.php?status=incorrect');
    }
}

/*Change Admin Password*/
if(isset($_POST['change'])){
    $password = $_POST['verify_password'];

    if(password_verify($password, $row['user_password'])) {
        $admin_id = (int)$_POST['admin_id'];
        $admin_new_password = $_POST['admin_new_password'];
        $admin_new_password=password_hash($admin_new_password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET user_password=:admin_new_password WHERE user_id=:admin_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':admin_new_password', $admin_new_password);
        $stmt->bindParam(':admin_id', $admin_id);
        $stmt->execute();

        header('Location: settings.php?page=change&status=success');

    }
    else{
        header('Location: settings.php?page=change&status=incorrect');
    }
}

/*Delete user except admin*/
if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    $stmt = $db->prepare('DELETE FROM users WHERE user_id=:id AND user_type!=:user_type');
    $stmt->bindValue(':user_type', 'admin');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if($stmt->rowCount()) {
        header('Location: settings.php?page=users&status=success');
    }
}

?>
<html lang="en">
<head>
    <title>Settings</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>

<?php require_once 'pages/nav.php' ?>

<div class="container">
    <h2 class="text-center">Settings</h2>
    <hr>
    <div class="nav-justified">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php if(!isset($_GET['page']))echo 'active'?>" href="settings.php">Edit Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($_GET['page']=="change")echo 'active'?>" href="?page=change">Change Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($_GET['page']=="users")echo 'active'?>" href="?page=users">Users</a>
            </li>
        </ul>
    </div>
        <?php
        /*Include Pages Upon Request*/
            if(isset($_GET['page'])){
                $page = $_GET['page'];

                switch($page){
                    case 'change':
                        include_once 'pages/change_password.php';
                        break;

                    case 'users':
                        include_once 'pages/users.php';
                        break;
                }
            }else{
                include_once 'pages/edit_profile.php';
            }
        ?>

</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>