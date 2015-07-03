<?php
include_once 'db_connect.php';
 
$error_msg = "";
 
if (isset($_POST['firstname'], $_POST['lastname'], $_POST['passwordHash'], $_POST['age'])) 
{
    // Sanitize and validate the data passed in
    // Strip tags, optionally strip or encode special characters.
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);

    $password = filter_input(INPUT_POST, 'passwordHash', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
 
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
 
    if (empty($error_msg)) {
        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database 
        if ($insert_stmt = $db->prepare("INSERT INTO tbl_customer (firstname, lastname, password, salt, age) VALUES (?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('ssssi', $firstname, $lastname, $password, $random_salt, $age);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../registration.php?err=Registration failure: INSERT');
            }
        }
        
        header('Location: register_success.php');
    }
}
?>