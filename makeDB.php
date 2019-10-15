<?php

include 'dbConnection.php';
$sql = "
CREATE TABLE `users` (
  `uid` bigint(20) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `signup_date` varchar(255) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



";
        if ($conn->query($sql) === TRUE) {
          echo 'Mission Completed successfully'
        }else{
          echo "bad Mission :("
        }


?>
