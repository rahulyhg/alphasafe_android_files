<?php
require_once 'connection.php';
header('Content-Type : application/json');

class Methods{
	private $con;
	private $db;

	function __construct(){
		$this->db=new init();
		$this->con=$this->db->connect();
	}
	public function storeUser($name,$email,$password,$pnum,$type,$sstate) {
        $uuid = uniqid('', true);

                 $authKey = "134249A6IlxT7kUYev585778f2";

$otp=rand(1000,9999);
//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "KIYOST";
$mobileNumber = $pnum;
//Your message to send, Add URL encoding here.
$message = urlencode("
Your KIYO Verification Code is :$otp. Valid for 10 mins.");

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

		$result=mysqli_query($this->con,"INSERT INTO users(unique_id,name,email,pnum,encrypted_password,otp,passme,type,created_at,state_all)VALUES('$uuid','$name','$email','$pnum','$password','$otp','0','$type',NOW(),'$sstate')");

        if ($result) {
			$uid=mysqli_insert_id($this->con);
			$result1=mysqli_query($this->con,"SELECT * FROM users WHERE id=$uid");
 			if (!$result1) {
   				 printf("Error: %s\n", mysqli_error($this->con));
   				 exit();
				}

            		return mysqli_fetch_array($result1);
        } else {
            return false;
        }
    }

	 public function UpdateUser($pnum,$password) {

		$result=mysqli_query($this->con,"UPDATE users SET encrypted_password='$password' WHERE salt='$pnum'");

        if ($result) {
			$uid=mysqli_insert_id($this->con);

			$result1=mysqli_query($this->con,"SELECT * FROM users WHERE id=$uid");

 			if (!$result1) {
   				 printf("Error: %s\n", mysqli_error($this->con));
   				 exit();
				}
					return mysqli_fetch_array($result1);
        } else {
            return false;
        }
    }

	public function getUserByPnumAndPassword($pnum, $password) {

    }

	public function isUserExisted($pnum) {
        $result = mysqli_query($this->con,"SELECT pnum FROM users WHERE pnum ='$pnum'");

		$no_of_rows=mysqli_num_rows($result);

		if($no_of_rows>0){
			return true;
		}else{
			return false;
			}
	}

	public function hashSSHA($password) {
		$salt=sha1(rand());

		$salt=substr($salt,0,10);

		$encrypted=base64_encode(sha1($password.$salt,true).$salt);
		$hash=array("salt"=>$salt,"encrypted"=>$encrypted);

		return $hash;


    }

	public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
public function forgotpass($pnum) {

        $result = mysqli_query($this->con,"SELECT * FROM users WHERE pnum ='$pnum'") or die(mysql_error());
		$no_of_rows=mysqli_num_rows($result);

		if($no_of_rows>0){
			$authKey = "134249A6IlxT7kUYev585778f2";

$otp=rand(1000,9999);
//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "KIYOST";
$mobileNumber = $pnum;
//Your message to send, Add URL encoding here.
$message = urlencode("Your KIYO Reset Password Code is :$otp. Valid for 10 mins.");

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
			$result1 =mysqli_fetch_array($result);
			$res=mysqli_query($this->con,"UPDATE users SET otp='$otp' WHERE pnum='$pnum'");
			if (!$result1) {
   				 printf("Error: %s\n", mysqli_error($this->con));
   				 exit();
				}
						return $result1;
			}

			else{
				return false;
			}

    }

 public function registernum($otp, $pass) {

        $result = mysqli_query($this->con,"SELECT * FROM users WHERE otp='$otp'") or die(mysql_error());
		$no_of_rows=mysqli_num_rows($result);

		if($no_of_rows>0){
        $resu= mysqli_query($this->con,"UPDATE users SET encrypted_password='$pass' WHERE otp='$otp'") or die(mysql_error());

			$result1 =mysqli_fetch_array($result);
			if (!$result1) {
   				 printf("Error: %s\n", mysqli_error($this->con));
   				 exit();
				}

				return $result1;
		}


			else{
				return false;
			}

    }
    public function prescans($uid,$content,$pack,$sterlizer,$sload,$sdate,$dqr,$type,$stme) {
       $result=mysqli_query($this->con,"INSERT INTO scanme(uid,content,pack,sterlizer,sload,sdate,dqr,type,stme)VALUES('$uid','$content','$pack','$sterlizer','$sload','$sdate','$dqr','$type','$stme')");

			  if ($result) {
			      		return $result;
        }
        else {
            return false;
        }


    }
		public function postscans($dqr)
		{
			$result=mysqli_query($this->con,"SELECT * FROM scanme WHERE  dqr ='$dqr'");
			$result1 =mysqli_fetch_array($result);
			if ($result1) {
				return $result1;
			}
			else {
				return false;
			}
		}
	public function postcolup($dqr,$postcol) {
		date_default_timezone_set("Asia/Calcutta");
		$today_date=date("Y-m-d");
		$timeg=date("h:i:s");
	         $result = mysqli_query($this->con,"SELECT * FROM scanme WHERE dqr='$dqr'") or die(mysql_error());
	 		$no_of_rows=mysqli_num_rows($result);

	 		if($no_of_rows>0){
	         $resu= mysqli_query($this->con,"UPDATE scanme SET postcolor='$postcol',pdate='$today_date',ptime='$timeg' WHERE dqr='$dqr'") or die(mysql_error());

	 			$result1 =mysqli_fetch_array($result);
	 			if (!$result1) {
	    				 printf("Error: %s\n", mysqli_error($this->con));
	    				 exit();
	 				}

	 				return $result1;
	 		}


	 			else{
	 				return false;
	 			}

	     }
			 public function biotscan($uid,$dqr,$eday,$etime) {
					$result=mysqli_query($this->con,"INSERT INTO biotestscanme(uid,biodqr,sdate,stime)VALUES('$uid','$dqr','$eday','$etime')");
					$resultmn=mysqli_query($this->con,"SELECT * FROM biotestscanme WHERE biodqr='$dqr' ");
$resulting=mysqli_fetch_array($resultmn);
					if ($resulting) {
					return $resulting;
					 }
					 else {
							 return false;
					 }


			 }
			 public function prepotst($id) {
					$result=mysqli_query($this->con,"SELECT * FROM strip_color WHERE id='$id' ");
				$result1 =mysqli_fetch_array($result);
					if ($result1) {
									return $result1;
					 }
					 else {
							 return false;
					 }
			 }
						 public function tstcheck($uid)
	 		{
	 			$result=mysqli_query($this->con,"SELECT * FROM scanme WHERE  uid ='$uid'");
	 			$result1 =mysqli_fetch_array($result);
	 			if ($result1) {
	 				return $result1;
	 			}
	 			else {
	 				return false;
	 			}
	 		}
			public function bioress($uid)
		 {
			 $result=mysqli_query($this->con,"SELECT * FROM biotestscanme WHERE  uid ='$uid'");
			 $result1 =mysqli_fetch_array($result);
			 if ($result1) {
				 return $result1;
			 }
			 else {
				 return false;
			 }
		 }
		 public function ppres($uid,$dqr,$resf) {
$result = mysqli_query($this->con,"SELECT * FROM scanme WHERE dqr='$dqr' AND uid='$uid'") or die(mysql_error());
				 $no_of_rows=mysqli_num_rows($result);

				 if($no_of_rows>0){
							$resu= mysqli_query($this->con,"UPDATE scanme SET type='posttest',tresult='$resf' WHERE dqr='$dqr'") or die(mysql_error());

					 $result1 =mysqli_fetch_array($result);
					 if (!$result1) {
									printf("Error: %s\n", mysqli_error($this->con));
									exit();
						 }

						 return $result1;
				 }


					 else{
						 return false;
					 }

					}
					public function clinicki($clinic,$address,$uid,$city,$phnum,$cemail,$pinc) {
						 $result=mysqli_query($this->con,"INSERT INTO clinic(duid,cname,address,city,pincode,phnum,emailid)VALUES('$uid','$clinic','$address','$city','$pinc','$phnum','$cemail')");
							if ($result) {
											return $result;
							}
							else {
									return false;
							}


					}
					public function clincdoc($uid) {
						 $result=mysqli_query($this->con,"SELECT * FROM clinic WHERE duid='$uid'");
						 	$resulttt =mysqli_fetch_array($result);
							if ($resulttt) {
											return $resulttt;
							}
							else {
									return false;
							}


					}

}

?>
