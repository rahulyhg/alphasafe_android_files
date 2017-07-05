<?php
include 'my_connect.php';
$uid=$_GET['uid'];

$sql = "SELECT * FROM scanme where uid='$uid'AND tresult='SAFE'";
$res = mysqli_query($con,$sql);
$safe=mysqli_num_rows($res);
$sql1 = "SELECT * FROM scanme where uid='$uid'AND tresult='UNSAFE'";
$res1 = mysqli_query($con,$sql1);
$unsafe= mysqli_num_rows($res1);
$sql12 = "SELECT * FROM scanme where uid='$uid'";
$res12 = mysqli_query($con,$sql12);
$total_test= mysqli_num_rows($res12);
$sqlbi = "SELECT * FROM biotestscanme where uid='$uid'";
$res1bi = mysqli_query($con,$sqlbi);
$bitest= mysqli_num_rows($res1bi);

$response["user"]["safe"] = $safe;
$response["user"]["unsafe"] = $unsafe;
$response["user"]["totalsafe"] = $total_test;
$response["user"]["bitest"] = $bitest;
echo json_encode($response);
mysqli_close($con);

?>
