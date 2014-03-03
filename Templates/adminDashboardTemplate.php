<html>
<head>
<title></title>
    <script src="javascript/jquery-1.10.1.min.js"></script>
    <script src="javascript/jquery-migrate-1.2.1.min.js"></script>
    <script src="javascript/p-test.js"></script>
    <link rel="stylesheet" type="text/css" href="css/pd.css">
</head>
<body>


<div>Hi, <span><?=$currentUser->getEmailAddress()?></span>
    <?php
    if($currentUser->getRole() == "admin"){
        ?>
        <a href="mydashboard.php">enter my dashboard here</a>
    <?php
    }
    ?>
    <button id="logout_button" style="margin-left: 700px">logout</button>
</div>



<div style="border: palevioletred solid 1px; padding:10px">
<span>show me all the pictures:</span> <button id="show-all-pics">go</button>
<br />
<br />
<span>search pictures by email address: </span><input type="text" id="emails" style="width:500px"/> <button id="search-by-email">go</button>(you can enter multiple emails, separating by comma)
</div>
<div id="picture-box">

</div>
<div style="padding: 5px;border-color: palevioletred;border-style:solid;border-width:1px; position: fixed;top:90%;right:10px">
    <span style="padding: 5px">you want to transfer </span><input type="text" disabled="true" id="transfer_pic_id"/> to  <input type="text" disabled="true" id="transfer_to_user"/><input type="button" value="confirm" id="delete_confirm"/>
</div>
<script>
    $(document).ready(function(){
        $("#show-all-pics").click(showAllPictures);
        $("#search-by-email").click(searchPicturesByEmail);
        $(".transfer_pic").change(selectTransferPic);
        $("#delete_confirm").click(confirmTransfer);
        $("#logout_button").click(logout);

    });

    function showAllPictures(){
        $.ajax({
            url: "admindashboard.php",
            type: "POST",
            dataType: "json",
            data: {show_all_pics : true},
            success: function(data){
                if(data["success"] == true){
                    if(data['picture_units'] != ""){
                        $("#picture-box").html(data['picture_units']);
                    }else{
                        $("#picture-box").html("<pre>No picture is uploaded yet!</pre>");
                    }
                }else{
                    alert('data retrieval failed!');
                }
                $("#delete_confirm").click(confirmTransfer);
                $(".transfer_pic").change(selectTransferPic);
                $(".transfer-to").keyup(specifyTransferUser);

            }
    });
    }

    function searchPicturesByEmail(){
       var email_string = $("#emails").val();

        $.ajax({
            url: "admindashboard.php",
           type: "post",
       dataType: "json",
           data: {email_filter : true,
                        emails : email_string
                 },
        success: function(data){
            if(data["success"] == true){
                if(data['picture_units'] != ""){
                    $("#picture-box").html(data['picture_units']);
                }else{
                    $("#picture-box").html("<pre>No picture is uploaded yet!</pre>");
                }
            }else{
                alert('data retrieval failed!');
            }
            $(".transfer_pic").change(selectTransferPic);
            $(".transfer-to").keyup(specifyTransferUser);
            $("#delete_confirm").click(confirmTransfer);
        }
        });

    }

    function selectTransferPic(){
        if($(this).is(':checked')){
            var picid = $(this).attr('id');
           $("#transfer_pic_id").val(picid);
        }else{
            $("#transfer_pic_id").val('');
        }
    }

    function specifyTransferUser(){
        var userEmail = $(this).val();
        $("#transfer_to_user").val(userEmail);
    }

    function confirmTransfer(){
        var userEmail = $("#transfer_to_user").val();
        var picid = $("#transfer_pic_id").val();

        if(userEmail == ""){
            alert("please specify a user");
        }else if(picid == ""){
            alert("please pick a picture");
        }else{
            $.ajax({
                url: "admindashboard.php",
               type: "POST",
           dataType: "json",
               data: {transfer_pic:true,
                      user_email: userEmail,
                      pic_id: picid
               },
            success: function(data){
                if(data['success'] == true){
                    alert("successfully updated");
                    $("#user-of-"+data['pic_id']).html(data['user_email']);
                }else{
                    alert("updated fail");
                }
                $("#transfer_to_user").val("");
                $(".transfer_pic").attr('checked',false);
                $(".transfer-to").val("");
                $("#transfer_pic_id").val("");
            }
            });
        }
    }
</script>
</body>
</html>