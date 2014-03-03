<?php
/**@var UserPictureEntity $userPicture
 */

foreach($userPicturesArray as $userPicture) {?>
    <div>
        <div>
            <h4 id="user-of-<?=$userPicture->getPictureId()?>"><?=$userPicture->getUserEmail()?></h4>
            <span>PictureId: <?=$userPicture->getPictureId()?></span><br />
            <span>Privacy: <?php if($userPicture->getPicturePrivacy() == 0){echo "Public";}else{echo "Private";}?></span><br />
            <span>Status: <?php if($userPicture->getPictureStatus() == 0){echo "available";}else{echo "has been deleted";}?></span>
        </div>
        <div>
            <div>
                <img src="<?=$userPicture->getThumbnail()?>"/>
                <?php
                if($userPicture->getPicturePrivacy() == 0 and $userPicture->getPictureStatus() == 0)
                {
                ?>
                <input type="checkbox" id="<?=$userPicture->getPictureId()?>" class="transfer_pic" />transfer this picture to: <input type="text" placeholder="please enter only one user" class="transfer-to"/>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
}
?>