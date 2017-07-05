<?php
require_once 'Methods.php';
header('Content-Type : application/json');

$db = new Methods();
$response = array("error" => FALSE);
if (isset($_POST['uid'])){
	$uid=$_POST['uid'];
	$dqr=$_POST['dqr'];
	$eday=$_POST['eday'];
  $etime=$_POST['etime'];

        // create a new user
        $user = $db->biotscan($uid,$dqr,$eday,$etime);
        if ($user) {


        $response["error"] = FALSE;
        $response["user"]["biodqr"] = $user["biodqr"];
        $response["user"]["sdate"] = $user["sdate"];
        $response["user"]["stime"] = $user["stime"];
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
