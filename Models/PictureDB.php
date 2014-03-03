<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 3:47 PM
 * To change this template use File | Settings | File Templates.
 */

require_once "PictureEntity.php";
require_once "UserPictureEntity.php";

class PictureDB {
    protected $con;
    public function __construct(){
        $this->con = mysqli_connect("localhost", "mypic", "mypic", "mypics");
    }

    //$privacy=0/1 => public/private, $status=0/1 => available/deleted
    public function addNewPicture($picTitle,  $picLocation, $userId, $thumbnail, $picDesc=null, $privacy=0, $status=0){
        if(!is_null($picDesc)){
            $picDesc = mysqli_escape_string($this->con, $picDesc);
        }

        $sqlQuery = "insert into p_pictures(picture_title,
                                 picture_desc,
                                 picture_loc,
                                 user_id,
                                 uploaded_date,
                                 privacy,
                                 status,
                                 thumbnail_loc)
                             values('{$picTitle}',
                                    '{$picDesc}',
                                    '{$picLocation}',
                                    '{$userId}',
                                     now(),
                                    '{$privacy}',
                                    '{$status}',
                                    '{$thumbnail}')";

        return mysqli_query($this->con, $sqlQuery);
    }

    public function getPicturesByUserId($userId, $orderBy="uploaded_date", $order="desc"){
        $sqlQuery = "select *
                     from p_pictures
                     where user_id = '{$userId}'
                     and status = 0
                     order by " . $orderBy. " ". $order;

        $result = mysqli_query($this->con, $sqlQuery);

        if(!mysqli_num_rows($result)){
            return false;
        }else{
            return $this->getPictureEntities($result);
        }

    }

    public function deletePicture($pictureIds, $userId){
        $picIds = join(',', $pictureIds);

        $sqlQuery = "update p_pictures
                     set status = 1
                     where user_id = {$userId}
                     and picture_id in ($picIds)";

        $result = mysqli_query($this->con, $sqlQuery);

        return $result;

    }

    public function getAllPicturesFromAllUsers($emailArray = null){
        $subString = '';

        $sqlQuery = "select u.user_id,
                            u.email_addr,
                            p.picture_id,
                            p.picture_loc,
                            p.privacy,
                            p.status,
                            p.uploaded_date,
                            p.thumbnail_loc
                       from p_user u, p_pictures p
                      where p.user_id = u.user_id
                      order by p.uploaded_date desc";

        if($emailArray != null){
            foreach($emailArray as $key => $email){
                $subString = $subString . "'" . $email . "'";
                if($key != sizeof($emailArray)-1){
                $subString = $subString . ",";
                }
            }
            $sqlQuery = $sqlQuery . " and u.email_addr in (".$subString.")";
        }

        $result = mysqli_query($this->con, $sqlQuery);

        if(!mysqli_num_rows($result)){
            return false;
        }else{
            return $this->getUserPictureEntities($result);
        }
    }

    public function updatePicOwnerWithPicId($userId, $pictureId){
        $sqlQuery = "update p_pictures
                        set user_id = {$userId}
                      where picture_id = {$pictureId}
                    ";
        $result = mysqli_query($this->con, $sqlQuery);

        return $result;
    }

    public function getUserPictureByPictureId($pictureId){
        $sqlQuery = "select u.user_id,
                            u.email_addr,
                            p.picture_id,
                            p.picture_loc,
                            p.privacy,
                            p.status,
                            p.thumnail_loc
                       from p_user u, p_pictures p
                      where p.user_id = u.user_id
                        and picture_id = {$pictureId}";
        $result = mysqli_query($this->con, $sqlQuery);

        if(!mysqli_num_rows($result)){
            return null;
        }else{
            return $this->getUserPictureEntity($result);
        }
    }

    public function getLatestPictureId(){
        $sqlQuery = "select picture_id
                       from p_pictures
                   order by picture_id
                       desc limit 1";

        $result = mysqli_query($this->con, $sqlQuery);

        if($result){
           if(mysqli_num_rows($result)>0){
               $row = mysqli_fetch_assoc($result);
               return $row['picture_id'];
           }else{
               return 0;
           }
        }else{
            return "get data failed";
        }
    }

    public function updatePictureDesc($picture_id, $picture_desc){
        $picture_desc = mysqli_real_escape_string($this->con,$picture_desc);

        $sqlQuery = "update p_pictures
                        set picture_desc = '{$picture_desc}'
                      where picture_id = {$picture_id}";

        $result = mysqli_query($this->con, $sqlQuery);

       return $result;
    }

    public function getPictureEntities($result){
        $pictureArray = array();


        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $pictureEntity = new PictureEntity();
            $pictureEntity->setPictureId($row['picture_id']);
            $pictureEntity->setTitle($row['picture_title']);
            $pictureEntity->setPicDesc($row['picture_desc']);
            $pictureEntity->setPictureLocation($row['picture_loc']);
            $pictureEntity->setUserId($row['user_id']);
            $pictureEntity->setUploadTime($row['uploaded_date']);
            $pictureEntity->setPrivacy($row['privacy']);
            $pictureEntity->setStatus($row['status']);
            $pictureEntity->setThumbnail($row['thumbnail_loc']);
            $pictureEntity->setViewCount($row['view_count']);
            $pictureEntity->setLikeCount($row['like_count']);

            array_push($pictureArray, $pictureEntity);
        }

        return $pictureArray;
    }

    public function getPictureEntity($result){
        $pictureEntity = new PictureEntity();
        $row = mysqli_fetch_assoc($result);
        $pictureEntity->setPictureId($row['picture_id']);
        $pictureEntity->setTitle($row['picture_title']);
        $pictureEntity->setPicDesc($row['picture_desc']);
        $pictureEntity->setPictureLocation($row['picture_loc']);
        $pictureEntity->setUserId($row['user_id']);
        $pictureEntity->setUploadTime($row['uploaded_date']);
        $pictureEntity->setPrivacy($row['privacy']);
        $pictureEntity->setStatus($row['status']);
        $pictureEntity->setThumbnail($row['thumbnail_loc']);
        $pictureEntity->setViewCount($row['view_count']);
        $pictureEntity->setLikeCount($row['like_count']);

        return $pictureEntity;

    }

    public function getUserPictureEntities($result){
        $userPictureArray = array();

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $userPictureEntity = new UserPictureEntity();
            $userPictureEntity->setUserId($row["user_id"]);
            $userPictureEntity->setUserEmail($row["email_addr"]);
            $userPictureEntity->setPictureId($row["picture_id"]);
            $userPictureEntity->setPictureLoc($row["picture_loc"]);
            $userPictureEntity->setPicturePrivacy($row["privacy"]);
            $userPictureEntity->setPictureStatus($row["status"]);
            $userPictureEntity->setThumbnail($row["thumbnail_loc"]);

            array_push($userPictureArray, $userPictureEntity);
        }
        return $userPictureArray;
    }

    public function getUserPictureEntity($result){

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $userPictureEntity = new UserPictureEntity();
            $userPictureEntity->setUserId($row["user_id"]);
            $userPictureEntity->setUserEmail($row["email_addr"]);
            $userPictureEntity->setPictureId($row["picture_id"]);
            $userPictureEntity->setPictureLoc($row["picture_loc"]);
            $userPictureEntity->setPicturePrivacy($row["privacy"]);
            $userPictureEntity->setPictureStatus($row["status"]);
            $userPictureEntity->setThumbnail($row["thumbnail_loc"]);


        return $userPictureEntity;
    }
}