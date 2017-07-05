<?php
require_once 'Methods.php';
header('Content-Type : application/json');

$db = new Methods();
$response = array("error" => FALSE);

if (isset($_POST['uid'])){
	$uid=$_POST['uid'];
		$dqr=$_POST['dqr'];
  $resf=$_POST['resf'];

        // create a new user
        $user = $db->ppres($uid,$dqr,$resf);
        if ($user) {
          $response["error"] = FALSE;
          echo json_encode($response);
        }
         else {
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
