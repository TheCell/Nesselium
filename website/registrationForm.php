<?php
require_once '../include/Database.class.php';

$error_msg = "";

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
        $error_msg .= 'Invalid password configuration.';
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
        $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING);
        try
        {
            $birthdateUTC = new DateTime( $birthdate,  new DateTimeZone( 'UTC' ) );
        } catch (Exception $ex) {
            $birthdateUTC = new DateTime( 'NOW',  new DateTimeZone( 'UTC' ) );
        }
    }
    if (isset($_POST['language']))
    {
        $language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_NUMBER_INT);
    }
    
    if (empty($error_msg)) {
        // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database
        $db = new Database();
        $nowUtc = new DateTime( 'now',  new DateTimeZone( 'UTC' ) );
        $now = $nowUtc->format('Y-m-d h:m:s');
        
        $sqlString = 'INSERT INTO tblUser (username, email, password, salt, createTime, firstname, lastname, birthday, FK_language, FK_usertype) '
                . 'VALUES (:username, :email, :password, :salt, :createTime, :firstname, :lastname, :birthday, :language, :usertype)';
        $variables = array (':username' => $username, ':email' => $email, ':password' => $password,
            ':salt' => $random_salt, ':createTime' => $now, ':firstname' => $firstname, ':lastname' => $lastname,
            ':birthday' => $birthdateUTC->format('Y-m-d'), ':language' => $language , ':usertype' => 7);
        
        $db->writeInfo($sqlString, $variables);
        
        header('Location: registrationSuccess.php');
    }
    else
    {
        header('Location: registration.php?error=' . $error_msg);
    }
    
}
?>