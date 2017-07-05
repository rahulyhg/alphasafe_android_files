<?php
require_once 'Methods.php';
header('Content-Type : application/json');

$db = new Methods();

$response = array("error" => FALSE);

if (isset($_POST['pnum']) && isset($_POST['password'])) {


    // receiving the post params
    $pnum = $_POST['pnum'];
    $password = $_POST['password'];



    // get the user by email and password
    $user = $db->getUserByPnumAndPassword($pnum, $password);

    if ($user != false) {


        $response["error"] = FALSE;
        $response["uid"] = $user["unique_id"];
        $response["user"]["name"] = $user["name"];
        $response["user"]["email"] = $user["email"];
        $response["user"]["passme"] = $user["passme"];
         $response["user"]["pnum"] = $user["pnum"];
								 $response["user"]["totstrip"] = $user["totstrip"];
        echo json_encode($response);



}
     else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Invalid Credentials.Kindly Signup!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters Mobile no or password is missing!";
    echo json_encode($response);
}

?>
