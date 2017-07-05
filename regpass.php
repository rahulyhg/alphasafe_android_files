<?php
require_once 'Methods.php';
header('Content-Type : application/json');

$db = new Methods();

$response = array("error" => FALSE);

if (isset($_POST['otp']) && isset($_POST['pass'])) {
	
 
    // receiving the post params
    $otp = $_POST['otp'];
    $pass = $_POST['pass'];
	
	
 
    // get the user by email and password
    $user = $db->registernum($otp, $pass);
 
    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
              echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters Mobile no or password is missing!";
    echo json_encode($response);
}

?>