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
    
    public function sanitizeString($string)
    {
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }
    
    public function sanitizeEmail($string)
    {
        $string = filter_input(INPUT_POST, $string, FILTER_SANITIZE_EMAIL);
        return $string;
    }
}

?>

