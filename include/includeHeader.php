<?php
    require_once 'Errorhandling.class.php';
    $errorhandler = new Errorhandler;
    $errorhandler->setHandler();
    require_once 'globalFunctions.php';
    require_once '../layout/header.html';
    sec_session_start();
    require_once '/../layout/nav.php';
?>