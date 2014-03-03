<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 5:10 PM
 * To change this template use File | Settings | File Templates.
 */
require_once "/var/www/html/picturediary/Models/PictureDB.php";
require_once "/var/www/html/picturediary/Models/UserEntity.php";

class MyDashBoardController {
    const IMAGE_PNG = 'image/png';
    const IMAGE_JPEG = 'image/jpeg';
    const IMAGE_GIF = 'image/gif';
    const USER_PIC_FOLDER = '/var/www/html/picturediary/pictures/users/';
    private $currentUser;
    private $pictureDB;

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
    }
        $this->pictureDB = new PictureDB();
    }

    public function myDashBoardHandler(){
      if($this->currentUser){
          if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_FILES["uploadPic"]) and $_POST['post_type'] == "temp_pic_only"){

              $this->uploadTempPicture();

          }elseif($_SERVER["REQUEST_METHOD"] == "POST" and $_POST['post_type'] == "add_pic"){
              if(!empty($_POST["pic_addr"])){
                  $picAddress = $_POST['pic_addr'];
              }
              if(!empty($_POST["pic_desc"])){
                  $picDesc = $_POST['pic_desc'];
              }
              if(!empty($_POST["pic_title"])){
                  $picTitle = $_POST['pic_title'];
              }

              $thumbnail = $this->generateThumbnail($picAddress);
              $this->uploadPictureToDb($picAddress, $picTitle, $picDesc,$thumbnail);
          }elseif($_SERVER["REQUEST_METHOD"] == "POST" and $_POST['post_type'] == "delete_pic"){
              $deletedPics = $_POST['deletingPicArray'];

              $this->removePictures($deletedPics, $this->currentUser->getUserId());

          }elseif($_SERVER["REQUEST_METHOD"] == "POST" and $_POST['order_by'] and $_POST['order']){
              $picturesArray = $this->pictureDB->getPicturesByUserId($this->currentUser->getId(), $_POST['order_by'], $_POST['order']);

              $this->displayTemplate($picturesArray, $this->currentUser);
          }elseif($_SERVER["REQUEST_METHOD"] == "POST" and $_POST["post_type"] == "update_title"){
              

          }else{

              $picturesArray = $this->pictureDB->getPicturesByUserId($this->currentUser->getUserId());

              $this->displayTemplate($picturesArray, $this->currentUser);

          }

      }else{
          header("location:login.php");
      }
    }

    public function uploadTempPicture(){
        $string = "";

        if($this->checkPictureType($_FILES['uploadPic']['type'])){
            $userId = $this->currentUser->getUserId();
            $pic_unique = $this->pictureDB->getLatestPictureId()+1;
            $uploadAddr = self::USER_PIC_FOLDER . $userId . '/';
            $picPath = '/picturediary/pictures/users/'. $userId . '/'.$pic_unique."_";

            $pictureName = basename($_FILES['uploadPic']['name']);

            if(!file_exists($uploadAddr)){
                mkdir($uploadAddr, 0775, true);
            }


            $uploadFile = $uploadAddr .$pic_unique."_". $pictureName;
            $picPath = $picPath . $pictureName;
            if(move_uploaded_file($_FILES['uploadPic']['tmp_name'], $uploadFile)){
                chmod($uploadFile, 0775);

                $string = $string . "<div id='success'>true</div>";
                $string = $string . "<div id='pic_address'>". $picPath. "</div>";
                $string = $string . "<div id='pic_title'>". $pictureName. "</div>";

            }
        }else{

            $string = $string . "<div id='success'>false</div>";
            $string = $string . "<div id='info'>invalid data type</div>";
        }

        echo $string;
    }

    public function checkPictureType($type){

        $allowedTypes = array(self::IMAGE_PNG, self::IMAGE_JPEG, self::IMAGE_GIF);

        if(in_array($type, $allowedTypes)){
            return true;
        }else{
            return false;
        }
    }

    public function uploadPictureToDb($pic_path, $pic_title, $pic_desc, $thumbnail){

        $uploadResult =  $this->pictureDB->addNewPicture($pic_title, $pic_path, $this->currentUser->getUserId(), $thumbnail, $pic_desc);

        if($uploadResult){
            $allPictures = $this->pictureDB->getPicturesByUserId($this->currentUser->getUserId());

            if(!empty($allPictures)){
                $showPics = $this->getPicsCollectionTemplate($allPictures);
                $result['picture_units'] = $showPics;
            }else{
                $result['picture_units'] = null;
            }

            $result['success'] = true;

        }else{
            $result['success'] = false;
            $result['info'] = "upload failed";
        }
        print_r(json_encode($result));

    }

    public function removePictures($deletedPicIds, $userId){
        $dbResult = $this->pictureDB->deletePicture($deletedPicIds, $userId);

        if($dbResult){
            $allPictures = $this->pictureDB->getPicturesByUserId($userId);

            if(!empty($allPictures)){
                $showPics = $this->getPicsCollectionTemplate($allPictures);
                $result['picture_units'] = $showPics;
            }else{
                $result['picture_units'] = null;
            }
            $result['success'] = true;
        }else{
            $result['success'] = false;
            $result['info'] = "delete failed";
        }
        print_r(json_encode($result));
    }

    public function generateThumbnail($picAddress){

       $partOfAddr = explode(".", $picAddress);

        $picAddress =  "/var/www/html".$picAddress;

        $thumbnail = $partOfAddr[0]."_thumbnail.jpg";

       $thumbnail_addr = "/var/www/html".$thumbnail;

       shell_exec("convert -quality 100 -scale 280x280 ".$picAddress." ".$thumbnail_addr);

       shell_exec("jhead -autorot ".$thumbnail_addr);


       return $thumbnail;
    }

    public function updatePictureDesc($picture_id, $updated_title){


    }

    public function displayTemplate($picArray, $user){
        $picturesArray = $picArray;
        $currentUser = $user;


        include_once "/var/www/html/picturediary/Templates/myDashboardTemplate.php";
    }

    public function getPicsCollectionTemplate($picArray){
        ob_start();
        $picturesArray = $picArray;

        include_once "Templates/picturesCollectionTemplate.php";

        $content = ob_get_contents();

        ob_end_clean();

        return $content;

    }

}