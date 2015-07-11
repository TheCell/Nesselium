<?php
// must be first statement
require_once '../include/includeHeader.php';
//require_once '../include/Stringvalidator.php';

echo 'index page';

//$db = new Database();

//$sqlQueryString = 'INSERT INTO tblCategory (name) VALUES ("test2");';

/*
$sqlQueryString = 'INSERT INTO tblArticle (text, FK_category, FK_user, FK_language, FK_userType_viewableBy) VALUES '
        . '(:text, :FK_category, :FK_user, :FK_language, :FK_userType_viewableBy);';
$variables = array(':text' => 'SQL injection <script>alert("that was easy");</script>', ':FK_category' => 1, ':FK_user' => 1, ':FK_language' => 1, ':FK_userType_viewableBy' => 8 );

echo $db->writeInfo($sqlQueryString, $variables);
*/


//$validate = new Stringvalidator();
//$sqlQueryString = "SELECT text FROM tblArticle";
//$articles = $db->getInfo($sqlQueryString);
//echo $validate->cleanXSS($articles[1]['text']);


//$sqlQueryString = 'INSERT INTO tblCategory (name) VALUES (:categorynames);';
//$variables = array(':categorynames' => 'multitest');
//$db->writeInfo($sqlQueryString, $variables);

// must be last statement
require_once '../include/includeFooter.php';
?>