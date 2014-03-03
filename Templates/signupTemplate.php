<!doctype html>
<html lang="en">
<head>
    <title></title>
    <script src="javascript/jquery-1.10.1.min.js"></script>
    <script src="javascript/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/pd.css">

</head>
<body>
    <div>

        <div>
            <form>
                <fieldset>

                    <div>
                        <label for="email">*Email Address</label>
                        <input id="email" type="email" placeholder="Email Address">
                    </div>

                    <div>
                        <label for="password">*Password</label>
                        <input id="password" type="password" placeholder="Password">
                    </div>

                    <div>
                        <label for="password_confirm">*Password Confirm</label>
                        <input id="password_confirm" type="password" placeholder="Password">
                    </div>

                    <div>
                        <label for="name">*Username</label>
                        <input id="name" type="text" placeholder="Username">
                    </div>

                </fieldset>
                <button id="signup_submit" type="button" class="pure-button pure-button-primary">Submit</button>
            </form>
        </div>
        <a href="login.php">have an account?Login here</a>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        $("#signup_submit").click(signupSubmit);
    });

    function signupSubmit(){
        var userName = $("#name").val();
        var password = $("#password").val();
        var passwordConfirm = $("#password_confirm").val();
        var email = $("#email").val();

        if(userName == "" || password == "" || passwordConfirm == "" || email == "" ){
            alert("fields marked with * are required");
        }else if(password != passwordConfirm){
            alert("please make sure you enter the same password twice.");
        }else{
            $.ajax({
                url:"signup.php",
                type: "POST",
                datatype: "json",
                data:{user_name: userName,
                    password: password,
                    email: email},
                success:function(response){
                    var result = JSON.parse(response);

                    if(result['success'] == "true"){
                        alert("your account is create successfully");

                        window.location.replace("mydashboard.php");
                    }else {
                        alert(result['error']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert(textStatus, errorThrown);}
            });
        }
    }
</script>
</body>
</html>
