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
         * @return type
         */
        public function getInfo($sqlQueryString, array $variables = array())
        {
            //TODO
            //check string for crossSiteScript
            
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
        
        public function writeInfo($sqlQueryString, array $variables = array())
        {
            //TODO
            //check string for sqlinjection
            
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