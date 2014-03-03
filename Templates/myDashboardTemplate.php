
<html>
<head>
    <title></title>
    <script src="javascript/jquery-1.10.1.min.js"></script>
    <script src="javascript/jquery-migrate-1.2.1.min.js"></script>
    <script src="javascript/p-test.js"></script>
    <link rel="stylesheet" type="text/css" href="css/pd.css">

</head>
<body>
<div>
    <div>

        <div class="content">
            <div>Hi, <span><?=$currentUser->getEmailAddress()?></span>
            <?php
            if($currentUser->getRole() == "admin"){
            ?>
            <a href="admindashboard.php">enter admin dashboard here</a>
            <?php
            }
            ?>
            <button id="logout_button" style="margin-left: 700px">logout</button>
            </div>
            <div>
                        <div>
                            <div>
                                <img style="height:70px;width:70px" src="pictures/add.jpg" alt="adding your picture" id="add_new_pic"/>click on the "+" button to select a pic.
                                <input type="hidden" id="img_location"/>
                                <input type="hidden" id="img_title" />
                                <form id="upload_pic" action="mydashboard.php" method="post" enctype="multipart/form-data" target="pic_upload_frame">
                                    <input type="file" style="display:none" id="uploadPic" name="uploadPic" />
                                    <input type="hidden" id="temp_upload_pic" name= "post_type" value="temp_pic_only"/>
                                </form>
                            </div>
                        </div>

                        <div>
                            <div>

                                <input id="pic_desc" type="text" style="width:330px;height:35px" placeholder="picture title"/>

                                <p>
                                    <button id="upload_pic_button">upload picture</button>
                                </p>
                            </div>
                        </div>

                <iframe id="pic_upload_frame" name="pic_upload_frame" style="display:none;">

                </iframe>
            </div>

            <div class="content" id="content-box">

                <!--picture unit is coming here-->
                <?php
                if($picturesArray){
                    include "Templates/picturesCollectionTemplate.php";
                }else{
                    echo "<pre>No picture is uploaded yet!</pre>";
                }
                ?>

            </div>

        </div>
    </div>
</div>
<div style="padding: 5px;border-color: palevioletred;border-style:solid;border-width:1px; position: fixed;top:90%;right:10px">
    <span style="padding: 5px">pictures you want to delete</span><input type="text" id="delete_pics_id"/> <input type="button" value="confirm" id="delete_confirm"/>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        deleteArray = new Array();

        $("#add_new_pic").click(addNewPic);
        $("#add_icon").click(addNewPic);
        $("#uploadPic").change(submitPicForm);
        $(".delete_pic").change(selectPictures);
        $("#upload_pic_button").click(submitPicInfo);
        $("#delete_confirm").click(deletePictures);
        $("#logout_button").click(logout);
        $(".edit-title-button").click(wantToChangeTitle);
        $(".cancel-edit-button").click(cancelChangeTitle);
        $(".edit-title-confirm").click(confirmChangeTitle);
    });

    function addNewPic(){
        $("#uploadPic").click();
    }

    function submitPicForm(){
        $("#upload_pic").submit();
        $("#pic_upload_frame").load(function(){
            var pic_addr =  $("#pic_upload_frame").contents().find("#pic_address").html();
            var pic_ttl =  $("#pic_upload_frame").contents().find("#pic_title").html();
            $("#add_new_pic").attr("src", pic_addr);
            $("#img_location").val(pic_addr);
            $("#img_title").val(pic_ttl);
        });
    }

    function submitPicInfo(){

        var pic_addr = $("#img_location").val();
        var pic_title = $("#img_title").val();
        var pic_desc = $("#pic_desc").val();

        if(pic_addr=="" || pic_title==""){
            alert("please select a upload file");
        }else{
        $.ajax({
            url: "mydashboard.php",
            type: "POST",
            dataType: "json",
            data: {pic_addr : pic_addr,
                pic_title : pic_title,
                pic_desc : pic_desc,
                post_type : "add_pic"
            },
            success: function(data){
                if(data['success'] == true){
                    if(data['picture_units'] != null){
                        $("#content-box").html(data['picture_units']);
                    }else{
                        $("#content-box").html("<pre>No picture is uploaded yet!</pre>")
                    }
                }else{
                    alert('data retrieval failed!');
                }
                $(".delete_pic").change(selectPictures);
                $("#add_new_pic").attr("src", "pictures/add.png");
                $("#img_location").val("");
                $("#img_title").val("");
                $("#pic_desc").val("")

            }
        });}
    }

    function selectPictures(){
            var picid = $(this).attr("id");
            if($(this).is(':checked')){
                deleteArray.push(picid);
            }else{
                deleteArray = $.grep(deleteArray,function(v){
                        return v != picid;
                });
            }
        $("#delete_pics_id").val(deleteArray);
    }

    function deletePictures(){
        if(deleteArray.length>0){
        var confirmDelete = confirm("Are you sure you want to delete the picture(s)?");
        if(confirmDelete){
            $.ajax({
                url: "mydashboard.php",
               type: "POST",
           dataType: "json",
               data: {deletingPicArray: deleteArray,
                      post_type: "delete_pic"},
            success: function(data){
                if(data['success'] == true){
                    if(data['picture_units'] != null){
                        $("#content-box").html(data['picture_units']);

                    }else{
                        $("#content-box").html("<pre>No picture is uploaded yet!</pre>")
                    }
                }else{
                    alert('data retrieval failed!');
                }
                $(".delete_pic").change(selectPictures);
            }
            });
        }
        }else{
            alert("please choose pictures you want to delete.");
        }
    }

    function wantToChangeTitle(){
         var editButtonId = $(this).attr("id");
         var id = editButtonId.substring(18);
         $(this).hide();
         $("#display-title-"+id).hide();
         $("#edit-title-"+id).show();
         $("#edit-title-confirm-"+id).show();
         $("#cancel-edit-button-"+id).show();
    }

    function cancelChangeTitle(){
        var cancelButtonId = $(this).attr("id");
        var id = cancelButtonId.substring(19);
        $(this).hide();
        $("#display-title-"+id).show();
        $("#edit-title-"+id).hide();
        $("#edit-title-confirm-"+id).hide();
        $("#edit-title-button-"+id).show();

    }

    function confirmChangeTitle(){
        var confirmButtonId = $(this).attr("id");
        var id = confirmButtonId.substring(19);
        var updatedTitle = $("#edit-title-"+id).val();
        $.ajax({
          url: "mydashboard.php",
         type: "post",
     dataType: "json",
         data: {pic_id:id,
                pic_title: updatedTitle,
                post_type: "update_title"},
      success: function(response){

      }
        });
    }

</script>
</body>
</html>

