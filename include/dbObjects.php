<?php
require_once 'dbConnect.php';

/*
 *  outdated
 */
/*
class User extends Connection
{
    private $PK_user;
    private $username;
    private $email;
    private $password;
    private $salt;
    private $createTime;
    private $firstname;
    private $lastname;
    private $birthday;
    private $lastLogin;
    private $ipAddressV4;
    private $ipAddressV6;
    private $usertype;
    private $language;
    
    function User ($PK_user)
    {
        $pdo = parent::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM tblUser WHERE PK_user = :userid");
        $stmt->execute(array(':userid' => $PK_user));
        $resultArr = $stmt->fetch();
  
        $this->PK_user = $resultArr['PK_user'];
        $this->username = $resultArr['username'];
        $this->email = $resultArr['email'];
        $this->password = $resultArr['password'];
        $this->salt = $resultArr['salt'];
        $this->createTime = new DateTime($resultArr['createTime']);
        $this->firstname = $resultArr['firstname'];
        $this->lastname = $resultArr['lastname'];
        $this->birthday = date($resultArr['birthday']);
        $this->lastLogin = new DateTime($resultArr['lastLogin']);
        $this->usertype = $resultArr['FK_usertype'];
        $this->language = $resultArr['FK_language'];
    }
    
    function showAll()
    {
        echo 'PK_user: ' . $this->PK_user . '<br />';
        echo 'Username: ' . $this->username . '<br />';
        echo 'email: ' . $this->email . '<br />';
        echo 'password: ' . $this->password . '<br />';
        echo 'salt: ' . $this->salt . '<br />';
        echo 'createTime: ' . $this->createTime->format('Y-m-d H:i:s') . '<br />';
        echo 'firstname: ' . $this->firstname . '<br />';
        echo 'lastname: ' . $this->lastname . '<br />';
        echo 'birthday: ' . $this->birthday . '<br />';
        echo 'lastLogin: ' . $this->lastLogin->format('Y-m-d H:i:s') . '<br />';
        echo 'usertype: ' . $this->usertype . '<br />';
        echo 'language: ' . $this->language . '<br />';
    }
}*/
?>