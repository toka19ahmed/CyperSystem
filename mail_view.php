<?php 
include_once  'upperlo.php';



  $boolcheck=true;
  $mid=$_GET["msgid"];
  $userId=$_SESSION["user_id"];


$sql = "SELECT m.mid 
FROM msg m ,users u , msgkeys k
where m.Mid=k.mid
and u.uid=k.rid
and u.uid=$userId
and m.mid=$mid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

       if($mid == $row["mid"] ) {
           {
              //make the Message in read mode
              $sql = "update msg set msRead=1 
              where Mid=$mid ";
              if ($conn->query($sql) === TRUE){
                //Wait to write Something
              }
           }
        $boolcheck=false;
       }
    }

    
} else {
     //header("Location: inbox.php");
     echo "<script> window.location.replace('inbox.php');     </script>";

}

if($boolcheck){
  echo "<script> window.location.replace('inbox.php');     </script>";

}






?>

<div class="col-sm-9">
            <section class="panel">
              <header class="panel-heading wht-bg">
                <h4 class="gen-case">
                    View Message
                   
                  </h4>
              </header>
              <div class="panel-body ">
                <div class="mail-header row">
                  <div class="col-md-8">
                    <h4 class="pull-left">
                      <?php
                     
                       $mid=$_GET["msgid"];
                     
                     $sql = "SELECT title FROM msg where mid=$mid ";
                     $result = $conn->query($sql);
                     if ($result->num_rows > 0) {
                         // output data of each row
                         while($row = $result->fetch_assoc()) {
                     
                           echo  $row["title"] ;
                               
                          
                         }                                         
                     } 
                      ?>
                    </h4>
                  </div>
                  <div class="col-md-4">
                    
                  </div>
                </div>
                <div class="mail-sender">
                  <div class="row">
                    <div class="col-md-8">
                      <img src="avatars/<?php 

                        $mid=$_GET["msgid"];

                        $sql = "SELECT u.*
                         FROM users u , msg s , msgkeys k 
                        where   u.uid=k.sid
                        and  s.mid=k.mid
                         and s.mid=$mid ";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {

                                $avatar=$row["avatar"];
                                echo $avatar;
                                                       
                                  }
                              }  

                       
                       ?>" alt="">

                      <?php
                     $mid=$_GET["msgid"];
                   
                   $sql = "select u.uname,u.email
                   from users u , msg s , msgkeys k
                   where u.uid=k.sid
                   and s.Mid=k.mid
                   and s.Mid=$mid";
                   $result = $conn->query($sql);
                   if ($result->num_rows > 0) {
                       // output data of each row
                       while($row = $result->fetch_assoc()) {
                         echo  " <strong>".$row["uname"]."</strong> " ;
                         echo  " (<strong>".$row["email"]."</strong>) " ;
                         echo  " to <strong>me</strong> " ;                         
                       }                                         
                   } 
                    ?>
                      
                    </div>
                    <div class="col-md-4">
                    <?php
                     
                     $mid=$_GET["msgid"];
                   
                   $sql = "select s.dates,s.times
                   from users u , msg s , msgkeys k
                   where u.uid=k.sid
                   and s.Mid=k.mid
                   and s.Mid=$mid";
                   $result = $conn->query($sql);
                   if ($result->num_rows > 0) {
                       // output data of each row
                       while($row = $result->fetch_assoc()) {
                   
                        echo  " <p class='date'>".$row["times"]." - ".$row['dates']."</p>" ;                         
                       }                                         
                   } 
                    ?>
                      
                    </div>
                  </div>
                </div>
                <div class="view-mail">

                   <?php
                     
                   $mid=$_GET["msgid"];  
                   
                   //getKey
   
                  $pKey=-1;          
                  $sql = "select  mrkey from msgkeys 
                  where mid=$mid";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                  
                        $pKey=$row["mrkey"];                         
                      }                                         
                  }


                   $sql = "select s.content
                   from users u , msg s , msgkeys k
                   where u.uid=k.sid
                   and s.Mid=k.mid
                   and s.Mid=$mid";
                   $result = $conn->query($sql);
                   if ($result->num_rows > 0) {
                       // output data of each row
                       while($row = $result->fetch_assoc()) {
                   
                        echo  " <p class='date'>".encrypt_decrypt('decrypt',$row["content"],$pKey)."</p>" ;                         
                       }                                         
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
                </div>
                
                <div class="compose-btn pull-left">
                  <a style="color:white;" href="mail_compose.php?uname=<?php
                       $friendUserName="";
                       $mid=$_GET["msgid"];
                     
                     $sql = "select u.uname,u.email
                     from users u , msg s , msgkeys k
                     where u.uid=k.sid
                     and s.Mid=k.mid
                     and s.Mid=$mid";
                     $result = $conn->query($sql);
                     if ($result->num_rows > 0) {
                         // output data of each row
                         while($row = $result->fetch_assoc()) {
                         $friendUserName=$row["uname"];
                                               
                         }                                         
                     }
                  echo $friendUserName
                   
                   
                   
                   ?>" class="btn btn-sm btn-theme"><i class="fa fa-reply"></i> Reply</a>
                </div>
              </div>
            </section>
          </div>

            <?php 
include 'lowerlo.php';

?>
