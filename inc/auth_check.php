<?php
if(!isset($_SESSION['admin']['login']) && !isset($_SESSION['user']['login'])){
    header('Location: index.php');
}
?>