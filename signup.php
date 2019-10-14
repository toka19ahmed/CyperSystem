<?php
session_start();
include 'dbConnection.php';
session_destroy();
if( isset($_POST["signup"]) )
{
    $username= htmlspecialchars($_POST["uname"]);
    $email=htmlspecialchars($_POST["email"]);
    $pwd=htmlspecialchars($_POST["pass"]);
    $confpwd=htmlspecialchars($_POST["re_pass"]);
    $dates=date('d-m-Y');

    //back-End Validation 
    $boolValid=false;
    $probMsg="";

   //input Formating Validation
    if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{5,20}$/', $username) ){
        $boolValid=true;
        $probMsg= "userName must start with Aplapetical and with 6-20 character";

    }
   else if(!(filter_var($email, FILTER_VALIDATE_EMAIL)) ) {
        //not Valid email!
        $boolValid=true;
        $probMsg= "not Valid Email";
   }
   else if ( !preg_match('/^(.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1})).{8,25}$/', $pwd) ){
    $boolValid=true;
    $probMsg=  "Password must Contain  8 to 25 characters which contain at least one numeric digit, one uppercase , one lowercase letter and one Sybmols";

  }else if (!($pwd==$confpwd))
  { 
    $boolValid=true;
    $probMsg= "repeated Password must be Identical";
  }


        //Check For Existance Validation
        //check for Existance of Username
        $sql = "select uname from users where uname='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              if( $row["uname"]==$username){
                $boolValid=true;
                $probMsg="Username already Exists , please change the Username";
              }
            }
        }

        //check for Existance of Email
        $sql = "select email from users ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              if( $row["email"]==$email){
                $boolValid=true;
                $probMsg="Email already Exists , please change the Email";
              }
            }
        }
   

   if($boolValid){


    $_SESSION["probMsg"]=$probMsg;
   }
    else{
        $pwd=md5($pwd);
      
        $sql = "insert into users values ('','$username','$pwd','$email','$dates')";
        if ($conn->query($sql) === TRUE) {
            echo "you  Registered successfully";
            header("Location: signin.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
   }

    

}   
       
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="sigingstyle/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="sigingstyle/css/style.css">
</head>
<body >

    <div class="main" >
        <!-- Sign up form -->
      
            <div class="container" style="position: relative; top:-110px;" >
                <div class="signup-content" >
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" required onkeyup="validateUserName(this.value);" name="uname" id="name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" required name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                            
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" required onkeyup="validatePassword(this.value);" name="pass" id="pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" required onkeyup="checkRePassword(this.value);" name="re_pass" id="re_pass" placeholder="Repeat your password"/>
                            </div>
                                <div style="text-align: center; position: relative;" >
                                    <center>
                                            <br><br>
                                         <label id="msg"><?php if(isset($_SESSION["probMsg"]))  echo "<span style='color:red'>".$_SESSION["probMsg"]."</span>" ?> </label>
                                        </center> 
   
                               </div>
                            
                            <div class="form-group form-button">
                                <br>
                                <input type="submit" onclick="return checkPass()" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="sigingstyle/images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="signin.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <script>
        

                // ForUserName
                function validateUserName(uName) {
            
            
            var matchedCase=/^[A-Za-z][A-Za-z0-9]{5,20}$/;     // Lowercase Alphabates

    
        if(uName.match(matchedCase)) 
        { 
            document.getElementById("msg").innerHTML = "";
            document.getElementById("msg").style.color = 'green';
        return true;
        }
        else
        { 
            document.getElementById("msg").innerHTML = "userName must start with Aplapetical and with 6-20 character";
            document.getElementById("msg").style.color = 'red';
        return false;
        }           
    }


                    // ForPassword
        function validatePassword(password) {
            
            
                var matchedCase=/^(.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1})).{8,25}$/;     // Lowercase Alphabates

        
            if(password.match(matchedCase)) 
            { 
                document.getElementById("msg").innerHTML = "";
                document.getElementById("msg").style.color = 'green';
            return true;
            }
            else
            { 
                document.getElementById("msg").innerHTML = "Password must Contain  8 to 25 characters which contain at least one numeric digit, one uppercase , one lowercase letter and one Sybmols";
                document.getElementById("msg").style.color = 'red';
            return false;
            }           
        }


            //For Re Password
      function checkRePassword(rePassword) {
            
         
                var matchedCase=/^(.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1})).{8,25}$/;     // Lowercase Alphabates

            password=document.getElementById("pass").value;

            if(!(password.match(matchedCase)))
            { 
                document.getElementById("msg").innerHTML = "Password must Contain  8 to 25 characters which contain at least one numeric digit, one uppercase , one lowercase letter and one Sybmols";
                document.getElementById("msg").style.color = 'red';
            return false;
            }
            else if (!(password==rePassword))
            { 
                document.getElementById("msg").innerHTML = "repeated Password must be Identical";
                document.getElementById("msg").style.color = 'red';
            return false;
            }else{
                document.getElementById("msg").innerHTML = "";
                document.getElementById("msg").style.color = 'green';
                return true;
            }          
        }


        /// for Submit

        function checkPass(){
            var matchedCase=/^(.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1})).{8,25}$/;     // Lowercase Alphabates

            password=document.getElementById("pass").value;
            rePassword=document.getElementById("re_pass").value;


            if(!(password.match(matchedCase)))
            { 
                document.getElementById("msg").innerHTML = "Password must Contain  8 to 25 characters which contain at least one numeric digit, one uppercase , one lowercase letter and one Sybmols";
                document.getElementById("msg").style.color = 'red';
            return false;
            }
            else if (!(password==(rePassword)))
            { 
                document.getElementById("msg").innerHTML = "repeated Password must be Identical";
                document.getElementById("msg").style.color = 'red';
            return false;
            }else{
                document.getElementById("msg").innerHTML = "";
                document.getElementById("msg").style.color = 'green';
                return true;
            }

        
        }
        
    </script>

    <script src="sigingstyle/js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>