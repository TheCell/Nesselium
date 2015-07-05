<?php
require_once 'dbConnect.php';

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
    
    $db = new Database();
    $sqlQueryString = "INSERT INTO tblErrorlog (type, errormsg, file, row) VALUES (:type, :errormsg, :file, :row)";
    $variables = array(':type' => $type, ':errormsg' => $message, ':file' => $file, ':row' => $row);
    $db->writeError($sqlQueryString, $variables);
    
    // Execute PHP internal error handler
    return false;
}

set_error_handler("errorHandler");