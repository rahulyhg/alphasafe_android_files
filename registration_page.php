<?php
include 'my_connect.php';


$name         = $_POST['name'];
$email        = $_POST['email'];
$password     = $_POST['password'];
$pnum         = $_POST['pnum'];
$type         = $_POST['type'];
$sstate       = $_POST['sstate'];
$uuid         = uniqid('', true);
$authKey      = "134249A6IlxT7kUYev585778f2";

$otp          = rand(1000,9999);
//Sender ID,While using route4 sender id should be 6 characters long.
$senderId     = "KIYOST";
$mobileNumber = $pnum;
//Your message to send, Add URL encoding here.
$message      = urlencode("Your KIYO Verification Code is :$otp. Valid for 10 mins.");

//Define route
$route                        = "4";
//Prepare you post parameters
$postData                     = array(
'authkey'                     => $authKey,
'mobiles'                     => $mobileNumber,
'message'                     => $message,
'sender'                      => $senderId,
'route'                       => $route
);

//API URL
$url                          = "https://control.msg91.com/api/sendhttp.php";

// init the resource
$ch                           = curl_init();
curl_setopt_array($ch, array(
CURLOPT_URL                   => $url,
CURLOPT_RETURNTRANSFER        => true,
CURLOPT_POST                  => true,
CURLOPT_POSTFIELDS            => $postData
//,CURLOPT_FOLLOWLOCATION     => true
));
//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);

$quuw= "INSERT INTO users(unique_id,name,email,pnum,encrypted_password,otp,passme,type,created_at,state_all)VALUES('$uuid','$name','$email','$pnum','$password','$otp','0','$type',NOW(),'$sstate')";
 $result = mysqli_query($con,$quuw);
 $result1 = mysqli_query($con,"SELECT * FROM users WHERE pnum ='$pnum'") ;
 $no_of_rows=mysqli_num_rows($result1);
 $user =mysqli_fetch_array($result1);


 $response["error"]          = FALSE;
 $response["uid"]            = $user["unique_id"];
 $response["user"]["name"]   = $user["name"];
 $response["user"]["email"]  = $user["email"];
 $response["user"]["pnum"]   = $user["pnum"];
 $response["user"]["otp"]    = $user["otp"];
 $response["user"]["passme"] = $user["passme"];
 $response["user"]["type"]   = $user["type"];
 echo json_encode($response);
}


 else {
// user failed to store
$response["error"]     = TRUE;
$response["error_msg"] = "User already exits";
echo json_encode($response);
}





?>
