<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/19/14
 * Time: 2:00 PM
 * To change this template use File | Settings | File Templates.
 */

class UserPictureEntity {
    private $userId;
    private $userEmail;
    private $pictureId;
    private $pictureLoc;
    private $picturePrivacy;
    private $pictureStatus;
    private $thumbnail;

    public function __construct(){}

    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function setUserEmail($userEmail){
        $this->userEmail = $userEmail;
    }

    public function getUserEmail(){
        return $this->userEmail;
    }

    public function setPictureId($pictureId){
       $this->pictureId = $pictureId;
    }

    public function getPictureId(){
        return $this->pictureId;
    }

    public function setPictureLoc($pictureLoc){
        $this->pictureLoc = $pictureLoc;
    }

    public function getPictureLoc(){
        return $this->pictureLoc;
    }

    public function setPicturePrivacy($privacy){
        $this->picturePrivacy = $privacy;
    }

    public function getPicturePrivacy(){
        return $this->picturePrivacy;
    }

    public function setPictureStatus($status){
        $this->pictureStatus = $status;
    }

    public function getPictureStatus(){
        return $this->pictureStatus;
    }

    public function setThumbnail($thumbnail){
        $this->thumbnail = $thumbnail;
    }

    public function getThumbnail(){
        return $this->thumbnail;
    }

}