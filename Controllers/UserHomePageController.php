<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/27/14
 * Time: 4:39 PM
 * To change this template use File | Settings | File Templates.
 */
require_once "/var/www/html/picturediary/Models/PictureDB.php";
require_once "/var/www/html/picturediary/Models/UserEntity.php";
require_once "/var/www/html/picturediary/Models/UserDB.php";


class UserHomePageController
{
    private $pictureDB;
    private $userDB;
    private $userEntity;
    private $currentUser;

    public function __construct()
    {
        $this->pictureDB = new PictureDB();
        $this->userDB = new UserDB();
        $this->userEntity = new UserEntity();

        session_start();
        if (isset($_SESSION["Expires"]) and time() > $_SESSION["Expires"]) {
            unset($_SESSION["user"]);
            unset($_SESSION["Authentication"]);
            session_destroy();
        } elseif(isset($_SESSION["user"])) {
            $this->currentUser = new UserEntity();
            $this->currentUser = $_SESSION["user"];
        }

    }

    public function userHomePageHandler()
    {
        if (isset($_GET["user_id"]) and !is_null($_GET["user_id"])) {
            $userIdOfPictures = $_GET["user_id"];
            $user = $this->userDB->getUserByUserId($userIdOfPictures);

            if (is_object($user)) {
                $this->getUserPictures($userIdOfPictures);
            }else {

                print("<h1>404! Page is not found!</h1>");

            }
        } else {
            //TODO redirect to explore page
        }
    }


    public function getUserPictures($userId)
    {
        $pictureArray = $this->pictureDB->getPicturesByUserId($userId);
        $user = $this->userDB->getUserByUserId($userId);
        $this->displayTemplate($pictureArray,$user);
    }

    public function displayTemplate($picArray,$user)
    {
        $pictureArray = $picArray;
        $currentUser = $this->currentUser;
        $userForThePage = $user;
        $defaultAvatar = 'pictures/default_avatar.png';

        include_once "/var/www/html/picturediary/Templates/userHomePageTemplate.php";
    }


}