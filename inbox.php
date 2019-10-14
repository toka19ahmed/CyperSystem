<?php 
include_once  'upperlo.php';


if(!(isset($_SESSION['user_id'] ))){
  header("Location: signin.php");

}

?>

<div class="col-sm-9">
            <section class="panel">
              <header class="panel-heading wht-bg">
                <?php 
                  $userId=$_SESSION['user_id'];
                    $sql = "select count(m.msRead) 
                    from msg m , msgkeys k 
                    where m.Mid=k.mid 
                    and k.rid=$userId 
                    and m.msRead=0";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<h4 class='gen-case'>Inbox (".$row["count(m.msRead)"].")</h4> " ;
                        }
                    } else {
                      echo "<h4 class='gen-case'>Inbox (0)</h4> " ;
                    }
                
                ?>
              </header>
              <div class="panel-body minimal">
                <div class="mail-option">

                  <!-- Don't remove -->
              
                </div>

                
                <div class="table-inbox-wrap ">
                  <table class="table table-inbox table-hover">
                    <tbody>
                                               <!-- Unread-->
              <?php
               $userId=$_SESSION['user_id'];



              
               

              $sql = "select m.mid, m.title, m.content ,m.dates ,m.msRead 
              from msg m , msgkeys k 
              where m.Mid=k.mid 
              and k.rid= $userId  order by m.mid desc";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    if($row["msRead"]=="0"){                   
                      echo "<tr class='unread'> " ;
                      echo "<td class='inbox-small-cells'>unread</td>";
                      echo "<td class='view-message  dont-show'><a href='mail_view.php?msgid=". $row["mid"]."'>".substr( $row["title"],0,10)."...</a></td> ";
                      echo "<td class='view-message '><a href='mail_view.php?msgid=". $row["mid"]."'>"."Open to View the Message".".</a></td>";
                      echo " <td class='view-message  inbox-small-cells'></td>";
                      echo "<td class='view-message  text-right'>".$row["dates"]."</td> ";
                      echo "</tr>";
                    }else {
                      
                        echo "<tr class=''>
                        <td class='inbox-small-cells'>read</td>                                                          
                        <td class='view-message dont-show'><a href='mail_view.php?msgid=". $row["mid"]."'>".substr( $row["title"],0,10)."..</a></td>
                        <td class='view-message'><a href='mail_view.php?msgid=". $row["mid"]."'>"."Open to View the Message"."</a></td>
                        <td class='view-message inbox-small-cells'></td>
                        <td class='view-message text-right'>".$row["dates"]."</td>
                      </tr>";
                    }

                  }
              } else {
                  echo "<span> <center>Inbox is Empty!</center></span>";
              }
           //   <td class='view-message'><a href='mail_view.php?msgid=". $row["mid"]."'>".$row["content"]."</a></td>



              //functionGetContent
              function functionGetContent($mid){
                $MessageContent="ss";
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
                   
                        $MessageContent=encrypt_decrypt('decrypt',$row["content"],$pKey);                         
                       }                                         
                   }
                   return $MessageContent;
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
                                                                 
                       
                                               <!-- Read-->

                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
          <?php 
include 'lowerlo.php';

?>
