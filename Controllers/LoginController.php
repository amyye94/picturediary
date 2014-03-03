<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 1:56 PM
 * To change this template use File | Settings | File Templates.
 */

require_once "/var/www/html/picturediary/Models/UserDB.php";

class LoginController {

    public function __construct(){


    }

    public function loginHandler(){

    session_start();
    if(isset($_SESSION['Expires']) and time() > $_SESSION['Expires']){
      unset($_SESSION['user']);
      unset($_SESSION['Authenticated']);
      session_destroy();
      }

    if(isset($_SESSION['user']) and $_SESSION['user']){

     header("location:mydashboard.php");

    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    isset($_POST['email_addr'])? $email_addr = $_POST['email_addr']:$email_addr = '';
    isset($_POST['password'])? $password = $_POST['password']:$password ='';

    $this->checkLogin($email_addr, $password);

     }
     else{
         $this->displayTemplate();
         }
    }

    public function checkLogin($email_addr, $password){

        $email_addr = stripslashes($email_addr);
        $password = stripslashes($password);
        $userDB = new UserDB();
        $loginCheckResult = $userDB->getUserByUserEmailAndPassword($email_addr, $password);

        if(is_object($loginCheckResult)){
            $result['login_success'] = true;
            $result['user_name'] = $loginCheckResult->getUserName();
            $userDB->updateLoginTime($loginCheckResult->getUserId());

            $_SESSION["user"] = $loginCheckResult;
            $_SESSION['Authenticated'] = true;
            $_SESSION['Expires'] = time() + 1800;
            print json_encode($result);

        }else{
            $result['login_success'] = false;
            print json_encode($result);
        }
    }

    function displayTemplate(){
        include_once "/var/www/html/picturediary/Templates/loginTemplate.php";

    }




}