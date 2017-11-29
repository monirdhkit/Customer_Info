<!doctype html>
<?php

session_name('auth');
session_set_cookie_params(time()*60*60*60,'/','',false,true);
session_start();
session_regenerate_id(true);

/*Store errors in an array*/
$errors = array();

if(isset($_SESSION['admin']['login'])){
    header('Location: dashboard.php');
}

if(isset($_SESSION['user']['login'])){
    header('Location: dashboard.php');
}

if(isset($_POST['login'])&&isset($_POST['email'])&&isset($_POST['password'])){
    /* Checking Fields are not empty to continue */
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        include 'inc/db.php';

        /*Checking user in database*/
        $stmt = $db->prepare("SELECT * FROM users WHERE user_email=:user_email");
        $stmt->bindParam(':user_email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount()){
        /* User is Authentication */
            if($row['user_type']=='admin'){
                /*User is Admin */

                /*Check Admin Password*/
                if(password_verify($password, $row['user_password'])){
                   /*Admin in Authenticated*/
                   $_SESSION['admin']['login'] = $row['user_name'];

                   if(isset($_SESSION['admin']['login'])){
                       header('Location: dashboard.php');
                   }
                }else{
                    $errors[2] = "Wrong Password.Try again.";
                }
            }
            /*User is user*/
            else{
                /*Check user password*/
                if(password_verify($password, $row['user_password'])){
                    /*User in Authenticated*/
                    $_SESSION['user']['login'] = $row['user_name'];
                    if(isset($_SESSION['user']['login'])){
                        header('Location: dashboard.php');
                    }
                }else{
                    $errors[2] = "Wrong Password.Try again.";
                }
            }

        }else{
            $errors[1] = "Account does not exists.Try again.";
        }

    }
    else{
        $errors[0] = "Fields can not be empty.";
    }
}

?>
<html lang="en">
<head>
    <title>Customer-Info | Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

</head>
<body>
<div class="container">

    <form class="form-login" method="post" action="login.php">
        <h2 class="form-login-heading">Please Login</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">

        <?php if(isset($_POST['login'])&&!is_null($errors)) :?>
            <ul class="col-12 mt-2">
                <div class="alert alert-warning" role="alert">
                    <?php foreach($errors as $error): ?>
                        <li style="list-style-type: none"><small><?php echo $error; ?></small></li>
                    <?php endforeach; ?>
                </div>
            </ul>
        <?php endif; ?>

        <button name="login" class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    </form>

</div> <!-- /container -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>