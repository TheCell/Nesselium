<?php
    require_once 'Errorhandling.class.php';
    $errorhandler = new Errorhandler;
    $errorhandler->setHandler();
    require_once '../layout/header.html';
    require_once 'Stringvalidator.class.php';
    require_once 'User.class.php';
    $user = new User;
    $user->sec_session_start();
    require_once '/../layout/nav.php';
?>