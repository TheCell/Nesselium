<?php
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

/**
 * @todo errorhandling
 */
function sec_session_start() 
{
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        //TODO
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one.
}

/**
 * 
 * @param type $PK_user
 * @param type $password
 * @return boolean
 * @license http://de.wikihow.com/Ein-sicheres-Login-Skript-mit-PHP-und-MySQL-erstellen wikiHow
 * @todo Will write the IP Address in the future
 */
function login($PK_user, $password) 
{
    $db = new Database();
    $sqlQueryString = "SELECT PK_user, username, password, salt FROM tbluser WHERE PK_user = :pkuser LIMIT 1";
    $variables = array(':pkuser' => $PK_user);
    $dbreturn = $db->getInfo($sqlQueryString, $variables);
    
    if (!empty($dbreturn))
    {
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $dbreturn[0]['salt']);
        if (checkbrute($PK_user) == true) 
        {
            // Account is locked 
            // Send an email to user saying their account is locked
            return false;
        }
        else
        {
            // Check if the password in the database matches
            // the password the user submitted.
            if ($dbreturn[0]['password'] == $password)
            {
                // Password is correct!
                $nowUtc = new DateTime( 'now',  new DateTimeZone( 'UTC' ) );
                $now = $nowUtc->format('Y-m-d h:m:s');
                $userIP = $_SERVER['REMOTE_ADDR'];
                $isSuccessfull = true;
                
                // TODO: add IP ADDRESS
//                $sqlQueryString = "INSERT INTO tblloginattempt (FK_user, ipAddressV4, loginTime, isSuccessfull)
//                                                VALUES (':pkuser', ':userIP', ':time', ':successState')";
//                $variables = array(':pkuser' => $PK_user, ':userIP' => $userIP, ':time' => $now, ':successState' => $isSuccessfull);
                $sqlQueryString = "INSERT INTO tblloginattempt (FK_user, loginTime, isSuccessfull)
                                                VALUES (:pkuser, :time, :successState)";
                $variables = array(':pkuser' => $PK_user, ':time' => $now, ':successState' => $isSuccessfull);
                $db->writeInfo($sqlQueryString, $variables);
                
                // Get the user-agent string of the user.
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                // XSS protection as we might print this value
                $PK_user = preg_replace("/[^0-9]+/", "", $PK_user);
                $_SESSION['PK_user'] = $PK_user;
                // XSS protection as we might print this value
                $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $dbreturn[0]['username']);
                
                $_SESSION['username'] = $username;
                $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

                // Login successful.
                return true;
            }
            else
            {
                // Password is not correct
                // We record this attempt in the database
                $nowUtc = new DateTime( 'now',  new DateTimeZone( 'UTC' ) );
                $now = $nowUtc->format('Y-m-d h:m:s');
                $userIP = $_SERVER['REMOTE_ADDR'];
                $isSuccessfull = false;
                // TODO IP ADDRESS
//                $sqlQueryString = "INSERT INTO tblloginattempt (FK_user, ipAddressV4, loginTime, isSuccessfull)
//                                                VALUES (':pkuser', ':userIP', ':time', ':successState')";
//                $variables = array(':pkuser' => $PK_user, ':userIP' => $userIP, ':time' => $now, ':successState' => $isSuccessfull);
                $sqlQueryString = "INSERT INTO tblloginattempt (FK_user, loginTime, isSuccessfull)
                                                VALUES (:pkuser, :time, :successState)";
                $variables = array(':pkuser' => $PK_user, ':time' => $now, ':successState' => $isSuccessfull);
                $db->writeInfo($sqlQueryString, $variables);
                return false;
            }
        }
    }
    // No user found
    return false;
}

/**
 * 
 * returns true if bruteforce was used
 * @param type $PK_user
 * @param Database $db
 * @return boolean
 * @license http://de.wikihow.com/Ein-sicheres-Login-Skript-mit-PHP-und-MySQL-erstellen wikiHow
 */
function checkbrute($PK_user)
{
    // Get timestamp of current time 
    $nowUtc = new DateTime( 'now',  new DateTimeZone( 'UTC' ) );
    $now = $nowUtc->format('Y-m-d h:m:s');

    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);

    $db = new Database();
    $sqlQueryString = "SELECT loginTime FROM tblloginattempt WHERE FK_user = :userid"
            . " AND loginTime > :time AND isSuccessfull = false";
    $variables = array(':userid' => $PK_user, ':time' => $valid_attempts);
    $dbarray = $db->getInfo($sqlQueryString, $variables);
    if (!empty($dbarray))
        {
        // If there have been more than 5 failed logins 
        if (sizeof($dbarray) > 5) {
               return true;
        } else {
               return false;
        }
    }
}

/**
 * 
 * @return boolean
 * @license http://de.wikihow.com/Ein-sicheres-Login-Skript-mit-PHP-und-MySQL-erstellen wikiHow
 */
function login_check()
{
    // Check if all session variables are set 
    if (isset($_SESSION['PK_user'], $_SESSION['login_string'])) 
    {
        $PK_user = $_SESSION['PK_user'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        $sqlQueryString = "SELECT password FROM tbluser WHERE "
                . "PK_user = :userid LIMIT 1";
        $variables = array(':userid' => $PK_user);
        $db = new Database();
        $dbreturn = $db->getInfo($sqlQueryString, $variables);

        if (!empty($dbreturn)) 
        {
            if (sizeof($dbreturn) == 1) 
            {
                // If the user exists get variables from result.
                $login_check = hash('sha512', $dbreturn[0]['password'] . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                }
                else
                {
                    // Not logged in 
                    return false;
                }
            }
            else
            {
                // Not logged in 
                return false;
            }
        }
        else
        {
            // Not logged in 
            return false;
        }
    } 
    else 
    {
        // Not logged in 
        return false;
    }
}