<?php


function errorHandler($type, $message, $file, $row)
{
    /*
     * The following error types cannot be handled with a user defined function:
     * E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR,
     * E_COMPILE_WARNING,
     * and most of E_STRICT raised in the file where set_error_handler() is called.
     */
    
    $servername = "localhost";
    $username = "erruser";
    $password = "";
    
    try
    {
        $pdoErr = new PDO("mysql:host=$servername;dbname=db_nesselium", $username, $password);
        // set the PDO error mode to exception
        $pdoErr->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         //echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    
    $stmtErr = $pdoErr->prepare("INSERT INTO tblErrorlog (type, errormsg, file, row)"
            . " VALUES (:type, :errormsg, :file, :row)");
    $stmtErr->execute(array(':type'=> $type, ':errormsg'=>$message,
        ':file'=>$file, ':row'=>$row ));

    $servername = "";
    $username = "";
    $password = "";
    $stmtErr = null;
    $pdoErr = null;

    // Execute PHP internal error handler
    return false;
}

set_error_handler("errorHandler");