<?php
include 'my_connect.php';
$response = array();
$id=$_GET['id'];
$uid=$_GET['uid'];
$sql = "SELECT * FROM recipe where id='$id' ORDER BY topic_name";
$res = mysqli_query($con,$sql);

$row = mysqli_fetch_array($res);
    $ids =$row['id'];
  $sql2n = "SELECT * FROM fav where uid='$uid' AND subcatg_id='$ids'";
  $res2n = mysqli_query($con,$sql2n);
  $row2n=mysqli_fetch_array($res2n);
  $fav_id=$row2n['favon'];
  if ($fav_id=="") {
    $fav_id="N";
  }
  else {
    $fav_id="Y";
  }
/*$response["result"]["id"]=$row["id"];
$response["result"]["catg_id"]=$row["catg_id"];
$response["result"]["topic_name"]=$row["topic_name"];
$response["result"]["short_desc"]=$row["short_desc"];
$response["result"]["ingredients1"]=$row["ingredients1"];
$response["result"]["method1"]=$row["method1"];
$response["result"]["times_viewed"]=$row["times_viewed"];
$response["result"]["images"]=$row["images"];
$response["result"]["audio"]=$row["audio"];
$response["result"]["video"]=$row["video"];
$response["result"]["active"]=$row["active"];*/
$response["result"]["favon"]=$fav_id;




echo json_encode($response);

mysqli_close($con);

?>
