<?php 
include_once  'upperlo.php';
$_SESSION["probMsg"]="";

if(isset($_POST["changeAvatar"])){
$avID=$_POST["avatar"];
$userId= $_SESSION['user_id'];
$sql = "update users set avatar=(select avatarpath from avatar where aid=$avID) where uid=$userId";
if ($conn->query($sql) === TRUE) {
    
$sql = "SELECT * FROM users where uid=$userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

           $_SESSION['avatar'] = $row["avatar"]; 
           echo "<script> window.location.replace('inbox.php');     </script>";

    }   
}

}
}


if(isset($_POST["change"])){
   

    $currentpwd=htmlspecialchars($_POST["cpwd"]);
    $pwd=htmlspecialchars($_POST["pwd"]);
    $confpwd=htmlspecialchars($_POST["repwd"]);
    $user_id=  $_SESSION['user_id'];


    if ( !preg_match('/^(.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1})).{8,25}$/', $pwd) ){
        $boolValid=true;
        $probMsg=  "Password must Contain  8 to 25 characters which contain at least one numeric digit, one uppercase , one lowercase letter and one Sybmols";
    
      }
      else if (!($pwd==$confpwd))
      { 
        $boolValid=true;
        $probMsg= "repeated Password must be Identical";
      }


    $boolValid=false;
    $probMsg="";
    $encpwd=md5($currentpwd);

     //check for Existance of Username
     $sql = "select pwd from users where uid='$user_id'";
     $result = $conn->query($sql);

     if ($result->num_rows > 0) {
         // output data of each row
         while($row = $result->fetch_assoc()) {
           if( $row["pwd"]!=$encpwd){
             $boolValid=true;
             $probMsg="Current Password is Wrong";
           }
         }
     }else{
             $boolValid=true;
             $probMsg="Current Password is Wrong";
     }

     if($boolValid){


        $_SESSION["probMsg"]=$probMsg;
       }else{
         
        $encpwd=md5($pwd);

        $sql = "update users set pwd='$encpwd' where uid=$user_id";
        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Password changed Successfully') </script>";
          //  header("Location: signin.php");
        }
       }



}


?>

<div class="col-sm-9">
            <section class="panel">
              <header class="panel-heading wht-bg">
                <h4 class="gen-case">
                    Avatar Gallery
                   
                  </h4>
              </header>
              <div class="panel-body ">
                <div class="mail-header row">
                  <div class="col-md-8">
                    <h4 class="pull-left">
                     
                    </h4>
                  </div>
                  <div class="col-md-4">
                    
                  </div>
                </div>
                <div class="mail-sender">

                <form method="post">
                 <div class="cc-selector">
                 <!--  Avatar 1-->
                 <input id="hacker" checked type="radio" name="avatar" value="1" />
                        <label class="drinkcard-cc hacker"for="hacker"></label>

                         <!--  Avatar 2-->
                         <input id="sadface" type="radio" name="avatar" value="2" />
                         <label class="drinkcard-cc sadface"for="sadface"></label>

                          <!--  Avatar 3-->
                        <input id="sonic" type="radio" name="avatar" value="3" />
                        <label class="drinkcard-cc sonic"for="sonic"></label>

                         <!--  Avatar 4-->
                         <input id="boy4" type="radio" name="avatar" value="4" />
                         <label class="drinkcard-cc boy4"for="boy4"></label>

                          <!--  Avatar 5-->
                        <input id="mask" type="radio" name="avatar" value="5" />
                        <label class="drinkcard-cc mask"for="mask"></label>

                         <!--  Avatar 6-->
                         <input id="boy6" type="radio" name="avatar" value="6" />
                         <label class="drinkcard-cc boy6"for="boy6"></label>

                          <!--  Avatar 7-->
                        <input id="smileface" type="radio" name="avatar" value="7" />
                        <label class="drinkcard-cc smileface"for="smileface"></label>

                         <!--  Avatar 8-->
                         <input id="girl8" type="radio" name="avatar" value="8" />
                         <label class="drinkcard-cc girl8"for="girl8"></label>

                         <!--  Avatar 9-->

                         <input id="girl9" type="radio" name="avatar" value="9" />
                         <label class="drinkcard-cc girl9"for="girl9"></label>

                          <!--  Avatar 10-->
                        <input id="girl10" type="radio" name="avatar" value="10" />
                        <label class="drinkcard-cc girl10"for="girl10"></label>

                          <!--  Avatar 11-->
                          <input id="girl11" type="radio" name="avatar" value="11" />
                        <label class="drinkcard-cc girl11"for="girl11"></label>

                         <!--  Avatar 12-->
                         <input id="girl12" type="radio" name="avatar" value="12" />
                         <label class="drinkcard-cc girl12"for="girl12"></label>

                        

                  
            </div>
                </div>
        
                <div class="view-mail">

                
                    
                </div>
                
                <div class="compose-btn pull-left">
                  <button type="submit" name="changeAvatar" class="btn btn-sm btn-theme"><i class="fa fa-reply"></i> Change Avatar</button>
                </div>
                </form>


                    <br><br><br><br><br><br><br>
         
                     <h2 >
                   Change Password
                   
                    </h2>
                    <br><br>
                    <form method="POST"> 
                   <label> Current Password</label>
                    <input type="password" requred onkeyup="CurrentPwd(this.value);" name="cpwd"  placeholder="" id="cpwd" class="form-control">
                    <br>
                    <label> new Password</label>
                    <input type="password" requred  onkeyup="validatePassword(this.value);"  name="pwd" placeholder="" id="pwd" class="form-control">
                    <br>
                    <label> Confirm new Password</label>
                    <input type="password" requred   onkeyup="checkRePassword(this.value);"  name="repwd" placeholder="" id="repwd" class="form-control">
                    <br> <br>
                    <label id="msg"><?php if(isset($_SESSION["probMsg"]))  echo "<span style='color:red'>".$_SESSION["probMsg"]."</span>" ?> </label>
                    <center><button class="btn btn-theme" name="change" onclick="return checkPass()" type="submit">Change</button></center>
                    </form>
              </div>
              <br><br><br><br><br><br><br>
            </section>
          </div> 
           
    <script>
        
        // ForPassword
        function CurrentPwd(password) {
    
    
    var matchedCase=/^(.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1})).{8,25}$/;     // Lowercase Alphabates


if(password.match(matchedCase)) 
{ 
    document.getElementById("msg").innerHTML = "";
    document.getElementById("msg").style.color = 'green';
return true;
}
else
{ 
    document.getElementById("msg").innerHTML = "Worng Current Password";
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

    password=document.getElementById("pwd").value;

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




 /// for Submit

        function checkPass(){
            var matchedCase=/^(.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1})).{8,25}$/;     // Lowercase Alphabates

            password=document.getElementById("pwd").value;
            rePassword=document.getElementById("repwd").value;


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



          
   <!--Avatars -->
            <?php 
include 'lowerlo.php';

?>
