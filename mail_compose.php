<?php 
include_once  'upperlo.php';
$_SESSION["successed"]="";
  
  
//session_start();


if(isset($_POST["submit"])){



  $senderuname= htmlspecialchars($_POST["senderuname"]);
  $title=htmlspecialchars($_POST["subject"]);
  $content=htmlspecialchars($_POST["content"]);

  $dates=date('d-m-Y');
  $times=date('h:m:a');
 
  $senderuname=clean($senderuname);
  $title=clean($title);
  $content=clean($content);



//back-End Validation 
$boolValid=false;
$probMsg="";
if (strlen($title)<1){
  $boolValid=true;
  $probMsg="Empty Title!";
}
else if (strlen($content)<1){
  $boolValid=true;
  $probMsg="Empty Message !";
}
  //Check For Existance Validation
        //check for Existance of Username
        $sql = "select uname from users where uname='$senderuname'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              if( $row["uname"]!=$senderuname){
                $boolValid=true;
                $probMsg="Wrong UserName";
              }
            }
        }else{
          $boolValid=true;
          $probMsg="Wrong UserName";
        }
        
         if($senderuname==$_SESSION['user_Name']){
          $boolValid=true;
          $probMsg="you Can't Send Message to yourself";
         }
        
    if($boolValid){
      $_SESSION["successed"]="<span style='Color:red;'>$probMsg </span>";

    }   
   else {
     //taking the id of Message
    $last_id=-1;
    $randomNumber = rand(11101,99999);

    $decrypted_txt = encrypt_decrypt('encrypt', $content,$randomNumber);

    //sending Msg
    $sql = "insert into msg values ('','$title','$decrypted_txt','$times','$dates','0')";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
      $_SESSION["successed"]="Message sent successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $userId=$_SESSION["user_id"];

    //Inserting Data to msgKeys
    $sql = "insert into msgkeys values ($userId,(select uid from users where uname ='$senderuname'),$last_id,'$randomNumber')";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }



   }
  




}

//Remove Special Character Function
function clean($string) {
  $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

  return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

//EncryptionMessage
function encrypt_decrypt($action, $string,$secret_key) {
  $output = false;
  $encrypt_method = "AES-256-CBC";
  //$secret_key = 15840;
  $secret_iv = ($secret_key/2)*17-691;
  // hash
  $key = hash('sha256', $secret_key);
  
  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
  $iv = substr(hash('sha256', $secret_iv), 0, 16);

  if ( $action == 'encrypt' ) {
      $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
      $output = base64_encode($output);
  } else if( $action == 'decrypt' ) {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}
?>

<div class="col-sm-9">
              <section class="panel">
                <header class="panel-heading wht-bg">
                  <h4 class="gen-case">
                      Compose Mail
                     
                    </h4>
                </header>
                <div class="panel-body">
                  
                  <div class="compose-mail">
                    <form role="form-horizontal" action="mail_compose.php" method="post">
                      <div class="form-group">
                        <label for="to" class="">To:</label>
                        <input name="senderuname" <?php if(isset($_GET["uname"])){ $friendName=$_GET['uname']; echo "value='$friendName'"; } ?> type="text" tabindex="1" id="to" class="form-control">
                        
                      </div>
                  
                      <div class="form-group">
                        <label for="subject" class="">Subject:</label>
                        <input name="subject" type="text" tabindex="1" id="subject" class="form-control">
                      </div>
                      <div class="compose-editor">
                        <label  >Content:</label>
                        <textarea name="content" class="wysihtml5 form-control" rows="9"></textarea>
                      </div>
                       <center id="msg" style="color:green;font-size:20px;"> <label>
                       <?php if(isset($_SESSION["successed"]))  echo "<span style='color:green'>".$_SESSION["successed"]."</span>" ?> 
                          
                          </label> </center>
                      <br><br>
                      <div class="compose-btn">
                        <button type="submit" name="submit" class="btn btn-theme btn-sm"><i class="fa fa-check"></i> Send</button>
                        
                      </div>
                    </form>
                  </div>
                </div>
              </section>
            </div>

            <?php 
include 'lowerlo.php';

?>
