<?php
    /**
     * This file will be included on every page, use the Objects provided here
     * Do no close the connection early: The connection will be closed automatically when the script ends.
     * This is to make sure, that included files that are included after your code
     * are still working
     */

    $servername = "localhost";
    $username = "root";
    $password = "";
    // These statement variables get nulled at the end of the website
    $stmt = "";
    $stmt2 = "";
    $stmt3 = "";

    class Connection
    {
        protected function getConnection()
        {
            $servername = "localhost";
            $username = "root";
            $password = "";
        
            try
            {
                $pdo = new PDO("mysql:host=$servername;dbname=db_nesselium", $username, $password);
                // set the PDO error mode to exception
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully";
                return $pdo;
            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }
    
    /**
     * Maybe change this, no multi insert very slow
     */
    class Database extends Connection
    {
        /**
         * 
         * @param type $sqlQueryString
         * @param array $variables
         * @return array
         */
        public function getInfo($sqlQueryString, array $variables = array())
        {
            //TODO
            //check string for crossSiteScript
            // create separate string validation file
            
            // no INSERT statements allowed
            if (preg_match("/INSERT/", strtoupper($sqlQueryString)) != 0)
            {
                $backtrace = debug_backtrace();
                errorHandler(2, "INSERT statement used in function getInfo by IP Adress: " . $_SERVER['REMOTE_ADDR'], $backtrace[0]['file'], $backtrace[0]['line']);
                return -1;
            }
            else
            {
                if (preg_match("/SELECT/", strtoupper($sqlQueryString)) == 1)
                {
                    $pdo = parent::getConnection();
                    $stmt = $pdo->prepare($sqlQueryString);
                    if (!empty($variables))
                    {
                        $stmt->execute($variables);
                    }
                    else
                    {
                        $stmt->execute();
                    }

                    $resultArr = $stmt->fetchAll();
                    return $resultArr;
                }
            }
            
        }
        
        /**
         * 
         * @param type $sqlQueryString
         * @param array $variables
         */
        public function writeInfo($sqlQueryString, array $variables = array())
        {
            //TODO
            //check string for sqlinjection
            //only let loged in users use this
            
            $pdo = parent::getConnection();
            $stmt = $pdo->prepare($sqlQueryString);
            if (!empty($variables))
            {
                $stmt->execute($variables);
            }
            else
            {
                $stmt->execute();
            }
        }
        
        public function writeError($sqlQueryString, array $variables = array())
        {
            $pdo = parent::getConnection();
            $stmt = $pdo->prepare($sqlQueryString);
            if (!empty($variables))
            {
                $stmt->execute($variables);
            }
            else
            {
                $stmt->execute();
            }
        }
    }
    
    // TODO
    define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!

    // clear the variables
    $servername = "";
    $username = "";
    $password = "";
?>