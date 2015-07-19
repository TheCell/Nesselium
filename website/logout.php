<?php
// must be first statement
require_once '../include/includeHeader.php';
$user = new User();
$user->logout();

header("Location: index.php");

// must be last statement
require_once '../include/includeFooter.php';
?>