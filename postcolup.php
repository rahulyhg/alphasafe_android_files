<?php
require_once 'Methods.php';
header('Content-Type : application/json');

$db = new Methods();
$response = array("error" => FALSE);

if (isset($_POST['dqr'])){
	$dqr=$_POST['dqr'];
  $postcol=$_POST['postcol'];

        // create a new user
        $user = $db->postcolup($dqr,$postcol);
        if ($user) {
          $response["error"] = FALSE;
          $response["user"]["uid"] = $user["uid"];
          $response["user"]["content"] = $user["content"];
          $response["user"]["pack"] = $user["pack"];
          $response["user"]["sterlizer"] = $user["sterlizer"];
          $response["user"]["sload"] = $user["sload"];
          $response["user"]["sdate"] = $user["sdate"];
          $response["user"]["dqr"] = $user["dqr"];
          $response["user"]["type"] = $user["type"];
          $response["user"]["precolor"] = $user["precolor"];
          $response["user"]["postcolor"] = $user["postcolor"];
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
