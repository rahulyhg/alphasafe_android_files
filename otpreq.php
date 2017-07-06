<?php
error_reporting(0);
include "my_connect.php";
$pnum  = $_POST['monum'];
$otp=$_POST['otp'];

$resul = mysqli_query($con,"SELECT  * FROM users WHERE pnum ='$pnum' AND otp='$otp'") ;
$result1 = mysqli_query($con,"UPDATE users SET passme='1' WHERE pnum='$pnum'") ;
$result = mysqli_query($con,"SELECT  * FROM users WHERE pnum ='$pnum' AND otp='$otp' AND passme='1' ") ;
if (mysqli_num_rows($result) > 0) {
 echo "success";
}
else {
    echo "failure";
}


?>
