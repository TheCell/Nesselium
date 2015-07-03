<?php
include_once 'functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['PK_customerNumber'], $_POST['passwordHash'])) {
    $PK_customerNumber = $_POST['PK_customerNumber'];
    $password = $_POST['passwordHash']; // The hashed password.
 
    if (login($PK_customerNumber, $password, $db) == true) {
        // Login success 
        header('Location: ../protected_page.php');
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}
?>