<?php
// must be first statement
require_once '../include/includeHeader.php';

function logout()
{
    // Setze alle Session-Werte zurück 
    $_SESSION = array();

    // hole Session-Parameter 
    $params = session_get_cookie_params();

    // Lösche das aktuelle Cookie. 
    setcookie(session_name(),
            '', time() - 42000, 
            $params["path"], 
            $params["domain"], 
            $params["secure"], 
            $params["httponly"]);

    // Vernichte die Session 
    session_destroy();
}

logout();
//header("Location: index.php");

// must be last statement
require_once '../include/includeFooter.php';
?>