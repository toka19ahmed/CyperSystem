<?php 
session_start();
$_SESSION['message']="";
include 'dbConnection.php';

if(isset($_POST["signin"])){


$username= htmlspecialchars($_POST["uname"]);
$pass=htmlspecialchars($_POST["pass"]);

//cleaning inputs
$username=clean($username);
//$pass=clean($pass);

$hashPass=md5($pass);
//echo $hashPass;

$sql = "SELECT * FROM users where uname='$username' and pwd='$hashPass'";
 $result = $conn->query($sql);
 
 if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {

        if($username == $row["uname"] && $hashPass == $row["pwd"]) {
            $_SESSION['user_id'] = $row["uid"];
            $_SESSION['user_Name'] = $row["uname"]; 
            $_SESSION['avatar'] = $row["avatar"]; 

            $_SESSION['Email'] = $row["email"]; 
            header("Location:inbox.php");


        }
     }

     
 } else {
     $_SESSION['message'] = "Invalid Login";
 }
}


 function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
  
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="sigingstyle/fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="sigingstyle/css/style.css">
</head>
<body>
    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container" style="position: relative; top:-110px;" >
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="sigingstyle/images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="signup.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" required name="uname" id="your_name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" required  name="pass" id="your_pass" placeholder="Password"/>
                            </div>
                          <span style="color:red;font-size:20px">
                          <?php if(isset($_SESSION["message"]))  echo "<span style='color:red'>".$_SESSION["message"]."</span>" ?> 
                           <span>
                            <div class="form-group form-button">
                            
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="sigingstyle/vendor/jquery/jquery.min.js"></script>
    <script src="sigingstyle/js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>