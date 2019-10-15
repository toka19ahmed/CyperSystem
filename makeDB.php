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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `pwd`, `email`, `signup_date`, `avatar`) VALUES
(8, 'hamedahmed', 'd890ae0571ea1ecb145880d089cb6e14', 's@s.c', '12-10-2019', '2.png'),
(9, 'hebafathi', 'd890ae0571ea1ecb145880d089cb6e14', 'mybns2018@gmail.com', '12-10-2019', '11.jpg'),
(10, 'waleed', 'd890ae0571ea1ecb145880d089cb6e14', 'hamed_kabo2011@yahoo.com', '14-10-2019', '6.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

";
        if ($conn->query($sql) === TRUE) {
          echo 'Mission Completed successfully'
        }else{
          echo "bad Mission :("
        }


?>
