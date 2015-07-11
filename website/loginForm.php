<?php
// must be first statement
require_once '../include/includeHeader.php';
require_once '../include/Stringvalidator.php';


if (isset($_POST['nameOrEmail']) && isset($_POST['password']))
{
    //check if username or email was used
    $stringvalidator = new Stringvalidator();
    $nameOrEmail = $stringvalidator->sanitizeString($_POST['nameOrEmail']);
    $password = $stringvalidator->sanitizeString($_POST['hashedPassword']);
    $pattern = "/@/";
    $db = new Database();
    
    if(preg_match($pattern, $nameOrEmail))
    {
        $sqlQueryString = "SELECT PK_user FROM tbluser WHERE email = :email LIMIT 1";
        $variables = array(':email' => $nameOrEmail);
        $dbReturn = $db->getInfo($sqlQueryString, $variables);
        $PK_user = $dbReturn[0]['PK_user'];
        login($PK_user, $password);
    }
    else
    {
        $sqlQueryString = "SELECT PK_user FROM tbluser WHERE username = :username LIMIT 1";
        $variables = array(':username' => $nameOrEmail);
        $dbReturn = $db->getInfo($sqlQueryString, $variables);
        $PK_user = $dbReturn[0]['PK_user'];
        login($PK_user, $password);
    }
}

// must be last statement
header('Location: index.php');

require_once '../include/includeFooter.php';
?>