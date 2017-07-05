<?php
include 'my_connect.php';
$id=$_GET['uid'];
$sql = "SELECT * FROM scanme where uid='$id'";
$res = mysqli_query($con,$sql);
$result = array();
$sql1 = "SELECT * FROM strip_color";
$res1 = mysqli_query($con,$sql1);
$row1=mysqli_fetch_array($res1);
while($row = mysqli_fetch_array($res)){
array_push($result,
array('content'=>$row[2],
'pack'=>$row[3],
'sterlizer'=>$row[4],
'sload'=>$row[5],
'sdate'=>$row[6],
'dqr'=>$row[7],
'type'=>$row[8],
'stme'=>$row[9],
'postcolor'=>$row[10],
'tresult'=>$row[11],
'pre_colr'=>$row1[1]

));
}

echo json_encode(array("users"=>$result));

mysqli_close($con);

?>
