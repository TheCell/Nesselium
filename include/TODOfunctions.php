<?php
include_once 'db_connect.php';









/*
 *  Functions for Error reporting
 *  All functions begin with 'err_'
 *  Error-Files localized in [project_root_dir]/error
 */

/**
 * Function err_report inserts error into error-file and returns message
 * @param String $err_file
 * @param String $err_msg
 * @param String $err_error
 * @return String
 */
function err_report($err_file, $err_msg, $err_type="Useraction", $err_error="User failed"){ //file wich caused error, message, php error
    $date = date('Y_m_d');
    $time = time('H:i:s');
    $FH = fopen("../error/".$date, "w") or die("Error reporting failed"); //no err_report because of loop risk
    fwrite($FH, '('.$time.') - File:'.$err_file.' - Message:'.$err_msg.' - Type:'.$err_type.' - Error:'.$err_error."\r\n");
    fclose($FH);
    return escapeshellarg($err_msg);
}
/**
 * Function err_getLast returns the last error, wich was reported
 * @return String
 */
function err_getLast(){ //TODO make possible to choose err_type
    $date = date('Y_m_d');
    while(!file("../error/".$date)){
        date_modify($date, '-1 day');
    }
    $file = file("../error/".$date);
    $line = $file[count($file)-1];
    return escapeshellarg($line);
}
/**
 * Function err_getReport returns report of wished day
 * @param today|date $date
 * @return String
 */
function err_getReport($date='today'){//TODO make possible to choose reportOfMonth or reportOfWeek
    if($date=='today'){
        $date = date('Y_m_d');
    }
    $FH = fopen("../error/".$date, "r") or die(err_report(__FILE__, "Getting error report failed", "System", "Unable to open file ../error/".$date));
    $report = fread($FH, filesize("../error/".$date));
    fclose($FH);
    return escapeshellarg($report);
}
?>