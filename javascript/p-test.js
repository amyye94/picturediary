function logout(){

    $.ajax({
        url : "logout.php",
        type : "POST",
        dataType : "json",
        data : {logout:true},
        success : function(data){
            if(data["success"] == true){
                alert("Logout successfully.");
                window.location.replace("login.php");
            }else{
                alert("logout error: " + data["error"]);
                window.location.reload(true);
            }
        }
    });
}