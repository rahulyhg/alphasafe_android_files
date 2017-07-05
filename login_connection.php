<?php
include 'my_connect.php';

$pnum = $_POST['pnum'];
$password = $_POST['password'];

$result = mysqli_query(con,"SELECT * FROM users WHERE pnum ='$pnum'") ;
$no_of_rows=mysqli_num_rows($result);
		if($no_of_rows>0){

			$result1 =mysqli_fetch_array($result);
			if ($result1['passme']==1) {

			}
			else
			{
				$authKey = "134249A6IlxT7kUYev585778f2";

$otp=rand(1000,9999);
//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "KIYOST";
$mobileNumber = $pnum;
//Your message to send, Add URL encoding here.
$message = urlencode("Your KIYO Verification Code is :$otp. Valid for 10 mins.");

//Define route
$route = "4";
//Prepare you post parameters
$postData = array(
    'authkey' => $authKey,
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
);

//API URL
$url="https://control.msg91.com/api/sendhttp.php";

// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
));
//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);
$result123=mysqli_query($this->con,"UPDATE users SET otp='$otp' WHERE pnum='$pnum'");


			if (!$result1) {
   				 printf("Error: %s\n", mysqli_error($this->con));
   				 exit();
				}

			$encrypted_password=$result1['encrypted_password'];


			if($encrypted_password==$password){
				return $result1;
			}
			else{
				return false;
			}

			}
		}
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


?>
