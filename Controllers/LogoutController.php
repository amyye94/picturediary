<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/19/14
 * Time: 12:12 PM
 * To change this template use File | Settings | File Templates.
 */

class LogoutController {

    public function __construct(){}

    public function logoutHandler(){
      session_start();
      if(isset($_POST["logout"]) and $_POST["logout"] == true){
        if($_SESSION['user']){
            unset($_SESSION['user']);
            unset($_SESSION['Authenticated']);
            session_destroy();

            $result["success"] = true;
        }else{
            $result["success"] =false;
            $result["error"] = "session expired";
        }
      }else{
            $result["success"] = false;
            $result["error"] = "error";
      }

        print_r(json_encode($result));
    }

}