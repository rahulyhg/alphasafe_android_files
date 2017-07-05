<?php
error_reporting(0);
include ("mysql_connect.php");
$pnum  = $_POST['monum'];
$otp=$_POST['otp'];
// get all items from myorder table
$resul = mysql_query("SELECT  * FROM users WHERE pnum ='$pnum' AND otp='$otp'") or die(mysql_error());
$result1 = mysql_query("UPDATE users SET passme='1' WHERE pnum='$pnum'") or die(mysql_error());
$result = mysql_query("SELECT  * FROM users WHERE pnum ='$pnum' AND otp='$otp' AND passme='1' ") or die(mysql_error());
if (mysql_num_rows($result) > 0) {
 echo "success";
}
else {
    echo "failure";
}


?>
