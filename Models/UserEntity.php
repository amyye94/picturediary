<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 11:44 AM
 * To change this template use File | Settings | File Templates.
 */

class UserEntity {
    private $userId;
    private $userName;
    private $email_address;
    private $password;
    private $role;
    private $avatar;

public function __construct(){

}

  public function setUserId($userId){
    $this->userId = $userId;
  }

  public function getUserId(){
    return $this->userId;
  }

  public function setUserName($userName){
    $this->userName = $userName;
  }

  public function getUserName(){
   return $this->userName;
  }

  public function setEmailAddress($email_addr){
    $this->email_address = $email_addr;
  }

  public function getEmailAddress(){
   return $this->email_address;
  }

  public function setPassword($pwd){
    $this->password = $pwd;
  }

  public function getPassword(){
   return $this->password;
  }

  public function setRole($role){
   $this->role = $role;
  }

  public function getRole(){
   return $this->role;
  }

  public function setAvatar($avatar){
    $this->avatar = $avatar;
  }

  public function getAvatar(){
    return $this->avatar;
  }
}