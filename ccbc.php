<?php
require_once 'Methods.php';
header('Content-Type : application/json');
$db = new Methods();
$response = array("error" => FALSE);
if (isset($_POST['uid'])){
	$uid=$_POST['uid'];


        // create a new user
        $user = $db->clincdoc($uid);
        if ($user) {
          $response["error"] = FALSE;
          $response["user"]["duid"] = $user["duid"];
          $response["user"]["cname"] = $user["cname"];
          $response["user"]["address"] = $user["address"];
          $response["user"]["city"] = $user["city"];
          $response["user"]["pincode"] = $user["pincode"];
          $response["user"]["phnum"] = $user["phnum"];
          $response["user"]["emailid"] = $user["emailid"];
              $response["error_msg"] = "Already scanned strip waiting for post scan ";
          echo json_encode($response);
        } else {

            $response["error"] = TRUE;
            echo json_encode($response);
        }


}

else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters Unique id is missing !";
    echo json_encode($response);
}

?>
