<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amyye94
 * Date: 2/18/14
 * Time: 3:41 PM
 * To change this template use File | Settings | File Templates.
 */

class PictureEntity {
    private $picture_id;
    private $picture_title;
    private $pic_desc;
    private $picture_location;
    private $user_id;
    private $upload_time;
    private $privacy;
    private $status;
    private $thumbnail_location;
    private $view_count;
    private $like_count;

    public function __construct(){

    }

    public function setPictureId($pic_id){
        $this->picture_id = $pic_id;
    }

    public function getPictureId(){
        return $this->picture_id;
    }

    public function setPictureLocation($pic_loc){
        $this->picture_location = $pic_loc;
    }

    public function getPictureLocation(){
        return $this->picture_location;
    }

    public function setUserId($userId){
        $this->user_id = $userId;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function setUploadTime($time){
        $this->upload_time = $time;
    }

    public function getUploadTime(){
        return $this->upload_time;
    }

    public function setPicDesc($desc){
        $this->pic_desc = $desc;
    }

    public function getPicDesc(){
        return $this->pic_desc;
    }

    public function setTitle($title){
        $this->picture_title = $title;
    }

    public function getTitle(){
        return $this->picture_title;
    }

    public function setPrivacy($privacy){
        $this->privacy = $privacy;
    }

    public function getPrivacy(){
        return $this->privacy;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getStatus(){
       return $this->status;
    }

    public function setThumbnail($thumbnail){
       $this->thumbnail_location = $thumbnail;
    }

    public function getThumbnail(){
      return $this->thumbnail_location;
    }

    public function setViewCount($view){
        $this->view_count = $view;
    }

    public function getViewCount(){
        return $this->view_count;
    }

    public function setLikeCount($like){
       $this->like_count = $like;
    }

    public function getLikeCount(){
        return $this->like_count;
    }
}