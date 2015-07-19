<?php

require_once 'Errorhandling.class.php';

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
    
    /**
    * 
    * This is used to stop a Cross-Site-Scripting attack, use this to filter
    * the Server variable $_SERVER['PHP_SELF']
    * @param type $url
    * @return string
    * @license http://de.wikihow.com/Ein-sicheres-Login-Skript-mit-PHP-und-MySQL-erstellen wikiHow
    */
   function esc_url($url) 
   {
       if ('' == $url) {
           return $url;
       }

       $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

       $strip = array('%0d', '%0a', '%0D', '%0A');
       $url = (string) $url;

       $count = 1;
       while ($count) {
           $url = str_replace($strip, '', $url, $count);
       }

       $url = str_replace(';//', '://', $url);

       $url = htmlentities($url);

       $url = str_replace('&amp;', '&#038;', $url);
       $url = str_replace("'", '&#039;', $url);

       if ($url[0] !== '/') {
           // We're only interested in relative links from $_SERVER['PHP_SELF']
           return '';
       } else {
           return $url;
       }
   }
}

?>

