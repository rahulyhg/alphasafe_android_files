<?php
require_once 'Methods.php';
header('Content-Type : application/json');


$db = new Methods();

$response = array("error" => FALSE);
if (isset($_POST['name']) && isset($_POST['pnum']) && isset($_POST['password'])){
	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$pnum=$_POST['pnum'];
	$type=$_POST['type'];
	$sstate=$_POST['sstate'];

	if ($db->isUserExisted($pnum)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $pnum;
        echo json_encode($response);
    }
     else {
        // create a new user
        $user = $db->storeUser($name, $email, $password,$pnum,$type,$sstate);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["pnum"] = $user["pnum"];
            $response["user"]["otp"] =$user["otp"];
            $response["user"]["passme"]=$user["passme"];
            $response["user"]["type"]=$user["type"];
						$response["user"]["totstrip"] = $user["totstrip"];
                       echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Server Busy!";
            echo json_encode($response);
        }
    }


}

else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}

?>
