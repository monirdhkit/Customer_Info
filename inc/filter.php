<?php

function XSS($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function valid_email($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return $email;
    }
    else{
        return null;
    }
}

function sanitize_email($email){
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}
?>