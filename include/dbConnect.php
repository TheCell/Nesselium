<?php
    /**
     * This file will be included on every page, use the Objects provided here
     * Do no close the connection early: The connection will be closed automatically when the script ends.
     * This is to make sure, that included files that are included after your code
     * are still working
     */

    $servername = "localhost";
    $username = "root";
    $password = "";
    // These statement variables get nulled at the end of the website
    $stmt = "";
    $stmt2 = "";
    $stmt3 = "";

    // We have 3 Database connections, you should use the first one as much as possible
    try
    {
        $pdo = new PDO("mysql:host=$servername;dbname=db_nesselium", $username, $password);
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    
    try
    {
        $pdo2 = new PDO("mysql:host=$servername;dbname=db_nesselium", $username, $password);
        // set the PDO error mode to exception
        $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    
    try
    {
        $pdo3 = new PDO("mysql:host=$servername;dbname=db_nesselium", $username, $password);
        // set the PDO error mode to exception
        $pdo3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    
    // TODO
    define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!

    // clear the variables
    $servername = "";
    $username = "";
    $password = "";
?>