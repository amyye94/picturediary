<html>
<head>
    <title></title>
    <script src="javascript/jquery-1.10.1.min.js"></script>
    <script src="javascript/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/pd.css">

</head>
<body>
<div>
    <input type="text" id="email_addr" placeholder="Email">
            <input type="password" id="login_password" placeholder="Password">

            <button type="button" id="login_button">Sign in</button>
    <a href="signup.php">sign up here!</a>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#login_button").click(clickOnLoginBtn);

        function clickOnLoginBtn(){

            var email_addr = $("#email_addr").val();
            var pswd = $("#login_password").val();

            if(email_addr !="" && pswd !=""){
            $.ajax({
                url: "login.php",
                type: "POST",
                datatype: "json",
                data: {
                    email_addr: email_addr,
                    password: pswd
                },
                success: function(response){
                    var result = JSON.parse(response);
                    if(result["login_success"] == false){
                        alert("login failed, username or password is not incorrect.");
                        window.location.reload(true);
                    }else if(result["login_success"] == true){

                        alert("login succeeded.");
                        window.location.replace("mydashboard.php");
                    }

                },
                error:function(jqXHR, textStatus, errorThrown){
                    alert(textStatus, errorThrown);}
            });
            }else{
                alert("please enter both username and password!");
            }
        }
    });
</script>
</body>
</html>