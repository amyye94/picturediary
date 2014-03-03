<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 11:44 AM
 * To change this template use File | Settings | File Templates.
 */
require_once "UserEntity.php";

class UserDB {

    protected $con;
    public function __construct(){
        $this->con = mysqli_connect("localhost", "mypic", "mypic", "mypics");
    }

    public function addUser($username, $password, $email){

        $currentTime = date("Y-m-d H:i:s");
        $username = mysqli_escape_string($this->con, $username);
        $password = mysqli_escape_string($this->con, $password);
        $email = mysqli_escape_string($this->con, $email);
        $role = "user";

        $sqlQuery = "insert into p_user(
                 user_name,
                 email_addr,
                 password,
                 register_date,
                 last_login_date,
                 role
                 )
                 values(
                 '{$username}',
                 '{$email}',
                 '{$password}',
                 '{$currentTime}',
                 '{$currentTime}',
                 '{$role}')";

        $result = mysqli_query($this->con, $sqlQuery);

        return $result;
    }

    public function getUserByUserName($userName){
        $userName = mysqli_real_escape_string($this->con, $userName);
        $mysqlQuery = "select *
                   from p_user
                   where user_name = '{$userName}'
    ";

        $result = mysqli_query($this->con, $mysqlQuery);

        if(!mysqli_num_rows($result)){
            return null;
        }else{
            return $this->getUserEntity($result);
        }
    }

    public function getUserByEmail($email){
        $email = mysqli_real_escape_string($this->con, $email);
        $mysqlQuery = "select *
                   from p_user
                   where email_addr = '{$email}'
    ";
        $result = mysqli_query($this->con, $mysqlQuery);

        if(!mysqli_num_rows($result)){
            return null;
        }else{
            return $this->getUserEntity($result);
        }

    }

    public function getUserByUserEmailAndPassword($email_addr, $password){
        $email_addr = mysqli_real_escape_string($this->con, $email_addr);
        $password = mysqli_real_escape_string($this->con, $password);
        $password = md5($email_addr.$password);

        $mysqlQuery = "select *
              from p_user
              where email_addr = '{$email_addr}'
              and password = '{$password}'";

        $result = mysqli_query($this->con, $mysqlQuery);

        if(!mysqli_num_rows($result)){
            return null;
        }elseif(mysqli_num_rows($result) == 1){
            return $this->getUserEntity($result);
        }
    }

    public function updateLoginTime($userId){

        $mysqlQuery = "update p_user
                   set last_login_date = date('Y-m-d H:i:s')
                   where user_id = '{$userId}'";

        $result = mysqli_query($this->con, $mysqlQuery);
        return $result;
    }

    public function getUserByUserId($userId){
        $userId = mysqli_real_escape_string($this->con, $userId);
        $mysqlQuery = "select *
                   from p_user
                   where user_id = '{$userId}'
    ";

        $result = mysqli_query($this->con, $mysqlQuery);

        if(!mysqli_num_rows($result)){
            return null;
        }else{
            return $this->getUserEntity($result);
        }
    }

    public function getUserEntity($result){

        $userEntity = new UserEntity();

        $row = mysqli_fetch_assoc($result);
        $userEntity->setUserId($row['user_id']);
        $userEntity->setUserName($row['user_name']);
        $userEntity->setEmailAddress($row['email_addr']);
        $userEntity->setPassword($row['password']);
        $userEntity->setRole($row['role']);
        return $userEntity;

}
}