<?php
require_once 'Methods.php';
header('Content-Type : application/json');

$db = new Methods();
$response = array("error" => FALSE);
if (isset($_POST['uid'])){
	$uid=$_POST['uid'];
	$clinic=$_POST['clinic'];
	$address=$_POST['address'];
	$city=$_POST['city'];
	$phnum=$_POST['phnum'];
    $cemail=$_POST['cemail'];
    $pinc=$_POST['pinc'];

        // create a new user
        $user = $db->clinicki($clinic,$address,$uid,$city,$phnum,$cemail,$pinc);
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
