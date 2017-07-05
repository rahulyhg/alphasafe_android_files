<?php
include 'my_connect.php';
$id=$_GET['uid'];
$sql = "SELECT * FROM biotestscanme where uid='$id'";
$res = mysqli_query($con,$sql);

$result = array();

while($row = mysqli_fetch_array($res)){
array_push($result,
array('biodqr'=>$row[2],
'sdate'=>$row[3],
'stime'=>$row[4],
'status'=>$row[5]

));
}

echo json_encode(array("result"=>$result));

mysqli_close($con);

?>
