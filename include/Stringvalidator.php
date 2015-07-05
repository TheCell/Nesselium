<?php

require_once 'errorhandling.php';

Class Stringvalidator
{
    public function cleanSqlInjection($string)
    {
        //TODO ?
        return $string;
    }
    
    public function cleanXSS($string)
    {
        $string = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
        return $string;
    }
}

?>

