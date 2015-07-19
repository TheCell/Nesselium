<?php
// must be first statement
require_once '../include/includeHeader.php';
require_once '../include/Stringvalidator.class.php';


if (isset($_POST['nameOrEmail']) && isset($_POST['password']))
{
    //check if username or email was used
    $stringvalidator = new Stringvalidator();
    $nameOrEmail = $stringvalidator->sanitizeString($_POST['nameOrEmail']);
    $password = $stringvalidator->sanitizeString($_POST['hashedPassword']);
    $pattern = "/@/";
    $db = new Database();
    $user = new User();
    
    if(preg_match($pattern, $nameOrEmail))
    {
        $sqlQueryString = "SELECT PK_user FROM tbluser WHERE email = :email LIMIT 1";
        $variables = array(':email' => $nameOrEmail);
        $dbReturn = $db->getInfo($sqlQueryString, $variables);
        $PK_user = $dbReturn[0]['PK_user'];
        if ($user->login($PK_user, $password))
        {
            // login passed
            header('Location: index.php');
        }
        else
        {
            // login failed
            header('Location: login.php?error=1');
        }
    }
    else
    {
        $sqlQueryString = "SELECT PK_user FROM tbluser WHERE username = :username LIMIT 1";
        $variables = array(':username' => $nameOrEmail);
        $dbReturn = $db->getInfo($sqlQueryString, $variables);
        $PK_user = $dbReturn[0]['PK_user'];
        if ($user->login($PK_user, $password))
        {
            // login passed
            header('Location: index.php');
        }
        else
        {
            // login failed
            header('Location: login.php?error=1');
        }
    }
}
else
{
    if (isset($_POST['nameOrEmail']))
    {
        // no Password
        header('Location: login.php?error=2');
    }
    else
    {
        // no name or login
        header('Location: login.php?error=3');
    }
}

echo "Ups something went wrong!";

// must be last statement
require_once '../include/includeFooter.php';
?>