<?php
require_once 'Methods.php';
header('Content-Type : application/json');

$db = new Methods();
$response = array("error" => FALSE);
if (isset($_POST['uid'])){
	$uid=$_POST['uid'];
	$content=$_POST['content'];
	$pack=$_POST['pack'];
	$sterlizer=$_POST['sterli'];
	$sload=$_POST['sload'];
    $sdate=$_POST['sdate'];
    $dqr=$_POST['dqr'];
    $type=$_POST['type'];
$stme=$_POST['stme'];
        // create a new user
        $user = $db->prescans($uid,$content,$pack,$sterlizer,$sload,$sdate,$dqr,$type,$stme);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Already scanned strip waiting for post scan ";
            echo json_encode($response);
        }


}

else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters Unique id is missing !";
    echo json_encode($response);
}

?>
