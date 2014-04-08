

<?php
/**
 *@var PictureEntity $picture
 */
foreach($picturesArray as $picture) {?>


        <div style="clear: both;overflow: auto">
            <div style="float: left;margin-bottom:30px;margin-right: 30px;width:280px">
                <img src="<?=$picture->getThumbnail()?>"/>

            </div>
            <div>
                <span style="margin-right: 10px">uploaded time:</span><?=$picture->getUploadTime()?><br/>

                <span style="margin-right: 10px">picture name:</span><?=$picture->getTitle()?><br/>


                <span style="margin-right: 10px">picture title:</span>
                <input style="display:none;width:300px;margin-right: 10px;margin-left: 10px;" type="text" id="edit-title-<?=$picture->getPictureId()?>" value="<?=$picture->getPicDesc()?>"/>
                <span style="margin-right: 10px;" id="display-title-<?=$picture->getPictureId()?>"><?=$picture->getPicDesc()?></span>
                <input type="button" class="edit-title-button" id="edit-title-button-<?=$picture->getPictureId()?>" value="edit title"/>
                <input style="display:none" type="button" class="edit-title-confirm" id="edit-title-confirm-<?=$picture->getPictureId()?>" value="confirm change">
                <input style="display:none" type="button" class="cancel-edit-button" id="cancel-edit-button-<?=$picture->getPictureId()?>" value="cancel"/>
                <br />
                <span style="margin-right: 10px">view:</span><?=$picture->getViewCount()?><br />
                <span style="margin-right: 10px">like:</span><?=$picture->getLikeCount()?><br />

                <span style="margin-right: 10px">public or not:</span><span><?=$picture->getPrivacy()==0?"public":"private"?></span>
                <input type="button" class="edit-privacy" id="edit-privacy-<?=$picture->getPictureId()?>" value="edit privacy"/><br />
                <input style="display:none" type="button" class="edit-privacy-confirm" id="edit-privacy-confirm-<?=$picture->getPictureId()?>" value="confirm change">
                <input style="display:none" type="button" class="cancel-privacy-button" id="cancel-privacy-button-<?=$picture->getPictureId()?>" value="cancel"/>
                <span style="margin-right: 10px">Album:</span><br />


                <label for="<?=$picture->getPictureId()?>">delete this picture</label><input type="checkbox" id="<?=$picture->getPictureId()?>" class="delete_pic" />
            </div>
        </div>

<?php
}
?>