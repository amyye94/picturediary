<html>
<head>
<title></title>
    <script src="javascript/jquery-1.10.1.min.js"></script>
    <script src="javascript/jquery-migrate-1.2.1.min.js"></script>
    <script src="javascript/p-test.js"></script>
    <link rel="stylesheet" type="text/css" href="css/pd.css">

    <style>
        .picture_box{
            width:280px;
            height:280px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        .picture_info_background{
            position: relative;
            bottom: 27px;
            padding: 4px;
            height: 20px;
            line-height: 16px;
            overflow: hidden;
            z-index: 3;
            background-color: #000;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";
            filter: alpha(opacity=40);
            opacity: 0.4;
        }

        .picture_info {
            position: relative;
            bottom: 50px;
            z-index: 3;
            color: white;
        }
    </style>
</head>
<body>
<div>
    <div id="content">

        <?php
        if($currentUser){
        ?>
        <div style="margin:20px;">Hi, <span><?=$currentUser->getEmailAddress()?></span>
            <?php
            if($currentUser->getRole() == "admin"){
                ?>
                <a href="admindashboard.php">enter admin dashboard here</a>
            <?php
            }
            ?>
            <button id="logout_button" style="margin-left: 700px">logout</button>
        </div>
        <?php
        }else{
            ?>
         <div style="margin:20px;"><a href="login.php">Login</a>....Or <a href="signup.php">join us</a> now </div>
        <?
        }
        ?>
        <div id="user_profile" style="margin:20px;clear:both;overflow:auto">
            <?php
            /**
             * @var UserEntity $user
             */
            ?>
            <div style=""><img style="border:#F0FFFF solid 5px;height:150px;width:150px;float:left;margin-right: 20px;max-width:100%" src="<?=$user->getAvatar()?$user->getAvatar():$defaultAvatar?>" /></div>
            <span>User Name:</span> <?print $user->getUserName();?><br/>
            <span>Email Address:</span><a href="mailto:<?=$user->getEmailAddress()?>"><?print $user->getEmailAddress();?></a><br/>
            <span>A little about me:</span>


        </div>
        <div id="picture_set">
            <?php
            /**@var PictureEntity $pic
             */
             if(!empty($pictureArray)){
               foreach($pictureArray as $key => $pic){
               if($key%4 == 0){
            ?>
               <div style="margin-right:20px;;margin-left: 20px;padding:2.5px;" class="picture_row">
                   <div style="padding:10px; margin:1px;float: left;background-color: #F2F2F2;" class="picture_box">
                       <a href="<?=$pic->getPictureLocation()?>" target="_blank"><img style="max-width: 100%;" src="<?=$pic->getThumbnail()?>" alt="<?=$pic->getTitle()?>"/></a>
                   <div class="picture_info_background" style=""></div>
                   <div class="picture_info"><?php echo $pic->getPicDesc();?></div>
                   </div>

            <? }elseif($key%4 == 3){ ?>

               <div style="padding:10px;margin:1px;float: left;background-color: #F2F2F2;" class="picture_box">
                   <a href="<?=$pic->getPictureLocation()?>" target="_blank"><img style="max-width: 100%" src="<?=$pic->getThumbnail()?>" alt="<?=$pic->getTitle()?>"/></a>
                   <div class="picture_info_background" style=""></div>
                   <div class="picture_info"><?php echo $pic->getPicDesc();?></div>
                   </div>
                   </div>

              <? }else{ ?>

               <div style="padding:10px;margin:1px;float: left;background-color: #F2F2F2;" class="picture_box">
                   <a href="<?=$pic->getPictureLocation()?>" target="_blank"> <img style="max-width: 100%;" src="<?=$pic->getThumbnail()?>" alt="<?=$pic->getTitle()?>"/></a>
                   <div class="picture_info_background" style=""></div>
                   <div class="picture_info"><?php echo $pic->getPicDesc();?></div>
               </div>
            <?  }
               }
             } else{?>
            <div style="margin-left:20px">
            <p>no picture is uploaded yet!</p>
            </div>
            <?php }?>

        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#logout_button").click(logout);

    });
</script>
</body>
</html>