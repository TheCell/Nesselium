<?php
require_once '../include/dbConnect.php';

$error_msg = "";
    var_dump($_POST);

if (isset($_POST['username'], $_POST['email'], $_POST['passwordHash']))
{
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'passwordHash', FILTER_SANITIZE_STRING);
    $firstname = "";
    $lastname = "";
    $birthdate = "";
    
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
    
    if (isset($_POST['firstname']))
    {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['lastname']))
    {
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['birthdate']))
    {
        echo $birthdate;
        $birthdate = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    }
    
    if (empty($error_msg)) {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database
        // TODO via userobj
        
        header('Location: registrationSuccess.php');
    }
    
}
?>