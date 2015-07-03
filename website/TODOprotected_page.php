<?php 
require_once 'includes/includeHeader.php';
if(login_check($db) == true) 
{
    $saldo = 0;
    ?>
        <h2>Home</h2>
    <?php
} 
else 
{ 
    ?>
        <p>You are not authorized to access this page, <a href="index.php">please login</a>.</p>
    <?php
}
?>
<?php
    require_once 'includes/includeFooter.php';
?>