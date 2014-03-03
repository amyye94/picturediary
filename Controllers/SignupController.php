<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 11:37 AM
 * To change this template use File | Settings | File Templates.
 */
require_once "/var/www/html/picturediary/Models/UserDB.php";

class SignupController {

    public function __construct(){

    }

    public function signUpRequestHandler()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){

            isset($_POST['user_name'])? $userName = $_REQUEST['user_name']:$userName = "";

            isset($_POST['email'])? $email = $_REQUEST['email']: $email = "";


            isset($_POST['password'])? $password = md5($email.$_REQUEST["password"]):$password = "";


        $userDB = new UserDB();

        if(is_object($userDB->getUserByEmail($email))){
            $result['error'] = "This email address has been registered.";
            $result['success'] = "false";
        }
        else {
            $status = $userDB->addUser($userName, $password, $email);
            if($status){
                $result['success'] = "true";
            }else{
                $result['success'] = "false";
                $result['error'] = "create account failed";
            }
        }
        print(json_encode($result));
    }else{
          $this->getTemplate();
        }
    }

    public function getTemplate(){
        include_once "/var/www/html/picturediary/Templates/signupTemplate.php";
    }

}