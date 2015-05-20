<?php
require_once 'dbConnect.php';

$stmt = $pdo->prepare('SELECT * FROM tblUser');
$stmt->execute();
?>