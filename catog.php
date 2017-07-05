<?php
include 'my_connect.php';
$sql = "SELECT * FROM category ORDER BY name";
$res = mysqli_query($con,$sql);
$result = array();

while($row = mysqli_fetch_array($res)){
array_push($result,
array('id'=>$row[0],
'name'=>$row[1],
'description'=>$row[2],
'image'=>$row[3],
'display_name'=>$row[4],
'active'=>$row[6]

));
}

echo json_encode(array("result"=>$result));

mysqli_close($con);

?>
