<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 11:38 AM
 * To change this template use File | Settings | File Templates.
 */
require_once "/var/www/html/picturediary/Models/PictureDB.php";
require_once "/var/www/html/picturediary/Models/UserEntity.php";
require_once "/var/www/html/picturediary/Models/UserDB.php";

class AdminDashBoardController {
    /**
     * @var UserEntity $currentUser
     *
     */
    private $currentUser;
    private $pictureDB;
    private $userDB;

    public function __construct(){
        session_start();
        if(isset($_SESSION['Expires']) and time() > $_SESSION['Expires']){
            unset($_SESSION['user']);
            unset($_SESSION['Authenticated']);
            session_destroy();
        }
        if(isset($_SESSION['user'])){
            $this->currentUser = new UserEntity();
            $this->currentUser = $_SESSION['user'];
            $this->pictureDB = new PictureDB();
            $this->userDB = new UserDB();
        }
    }

    public function adminDashBoardHandler(){
     if($this->currentUser){
      if($this->currentUser->getRole() != "admin"){
          header("location:mydashboard.php");
      }

      if($_SERVER["REQUEST_METHOD"] == "POST"){

          if(isset($_POST["show_all_pics"]) and $_POST["show_all_pics"] == true){

             $this->showAllUserPictures();

          }elseif(isset($_POST["email_filter"]) and $_POST["email_filter"] == true){

              $emailString = $_POST["emails"];
              $this->filterPicturesByUserEmails($emailString);

          }elseif(isset($_POST["transfer_pic"]) and $_POST["transfer_pic"] == true){

                      $pictureId = $_POST["pic_id"];
                      $emailAddr = $_POST["user_email"];
                   $this->transferPictureToAnotherUser($emailAddr, $pictureId);
          }
        }else{
          $this->displayTemplate($this->currentUser);

        }
     }else{
         header("location:login.php");
     }
    }

    public function showAllUserPictures(){
     $allUserPictures = $this->pictureDB->getAllPicturesFromAllUsers();

     if(!empty($allUserPictures)){
      $result["picture_units"] = $this->getPicsCollectionTemplate($allUserPictures);
     }else{
         $result["picture_units"]=null;
     }
        $result["success"] = true;

        print_r(json_encode($result));
    }

    public function filterPicturesByUserEmails($emailString){
       $emailArray = explode(',',$emailString);
       $pictureArray = $this->pictureDB->getAllPicturesFromAllUsers($emailArray);

        if(!empty($pictureArray)){
            $result["picture_units"] = $this->getPicsCollectionTemplate($pictureArray);
        }else{
            $result["picture_units"]=null;
        }
        $result["success"] = true;

        print_r(json_encode($result));

    }

    /**
     * @param UserPictureEntity $userPicture
     */
    public function transferPictureToAnotherUser($emailAddr, $picId){

       $user = $this->userDB->getUserByEmail($emailAddr);
       $userId = $user->getUserId();
       $dbResult = $this->pictureDB->updatePicOwnerWithPicId($userId, $picId);

        if($dbResult){
            $userPicture = $this->pictureDB->getUserPictureByPictureId($picId);
            $result['success'] = true;
            $result['user_email'] = $userPicture->getUserEmail();
            $result['pic_id'] = $picId;
        }else{
            $result['success'] = false;
            $result['info'] = "update owner failed";
        }
        print_r(json_encode($result));

    }

    public function displayTemplate($user){
        $currentUser = $user;
        include_once "/var/www/html/picturediary/Templates/adminDashboardTemplate.php";
    }

    public function getPicsCollectionTemplate($picArray){
        ob_start();
        $userPicturesArray = $picArray;

        include_once "/var/www/html/picturediary/Templates/picturesCollectionManagementTemplate.php";

        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }
}