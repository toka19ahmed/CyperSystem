<?php
session_start();
include 'dbConnection.php';

if(!(isset($_SESSION['user_id'] ))){
  header("Location: signin.php");

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>Cyber Security Project</title>

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" type="text/css" href="newStyle.css">



  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
 
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="index.html" class="logo"><b>Cyber<span>System</span></b></a>
      <!--logo end-->
      <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
          <!-- settings start -->
          
          <!-- settings end -->

          <!-- inbox dropdown start-->
          
          <!-- inbox dropdown end -->


          <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
      </div>
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
          <li><a class="logout" href="Logout.php">Logout</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><img src="avatars/<?php  echo $_SESSION["avatar"] ?>" class="img-circle" width="80"></p>
          <h5 class="centered"><?php  echo $_SESSION["user_Name"] ?></h5>
         
              
          
          <li>
            <a class="  <?php 
           $pageName=$_SERVER['PHP_SELF'];
           $search = 'inbox';
           $search2='mail_compose';
           $search3='mail_view';
           if(preg_match("/{$search}/i", $pageName)) {
               echo 'active';
           }else if(preg_match("/{$search2}/i", $pageName)){
            echo 'active';

           }
           else if(preg_match("/{$search3}/i", $pageName)){
            echo 'active';

           }
           
           ?>" href="inbox.php">
              <i class="fa fa-envelope"></i>
              <span>Mail </span>
              <span class="label label-theme pull-right mail-info"></span>
              </a>
          </li>
       
          <li>
            <a class="
            <?php 
           $pageName=$_SERVER['PHP_SELF'];
           $search = 'setting';
           if(preg_match("/{$search}/i", $pageName)) {
               echo 'active';
           }
           
           ?>
            " href="setting.php">
              <i class="fa fa-cog"></i>
              <span>Setting </span>
              <span class="label label-theme pull-right mail-info"></span>
              </a>
          </li>



        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!-- page start-->
        <div class="row mt">
          <div class="col-sm-3">
            <section class="panel">
              <div class="panel-body">
                 <a href="mail_compose.php" class="btn btn-compose">
                 <span style="color:white;"> <i class="fa fa-pencil"></i>  Compose Mail </span>
                  </a>
                <ul class="nav nav-pills nav-stacked mail-nav">
                  <li class="active"><a href="inbox.php"> <i class="fa fa-inbox"></i> Inbox  <span class="label label-theme pull-right inbox-notification"></span></a></li>
                  
                 <!-- <li><a href="#"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                  <li><a href="#"> <i class="fa fa-exclamation-circle"></i> Important</a></li>
                  <li><a href="#"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-info pull-right inbox-notification">8</span></a></a>
                  </li>
                  <li><a href="#"> <i class="fa fa-trash-o"></i> Trash</a></li> -->
                </ul>
              </div>
            </section>
            <section class="panel">
              <div class="panel-body">

                <ul class="nav nav-pills nav-stacked labels-info ">
                  <li>
                    <h4>Users in the WebSite</h4>
                  </li>
                  <li>
                      
                      <?php
                     
            $sql = "SELECT * FROM users ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $friendUser=$row["uname"];
                    $avatar=$row["avatar"];
                  if($friendUser!=$_SESSION["user_Name"]){
                  echo"  <a href='mail_compose.php?uname=$friendUser'>
                        <img src='avatars/$avatar' class='img-circle' width='30'>".$friendUser."                     
                      </a>";
                    }
                                           
                      }
                  }                             
           else {
                //header("Location: inbox.php");
                echo "There's No users";
            }

          ?>
                      
                     

                  </li>  
                                                              
                </ul>   

              </div>
            </section>
          </div>
       