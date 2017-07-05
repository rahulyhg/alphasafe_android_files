<?php
require_once 'Methods.php';
header('Content-Type : application/json');
$db = new Methods();
$response = array("error" => FALSE);
$id=1;
        $user = $db->prepotst($id);
        if ($user) {
        $response["error"] = FALSE;
          $response["user"]["pre_colr"] = $user["pre_colr"];
          $response["user"]["post_colr"] = $user["post_colr"];
          echo json_encode($response);
        }
         else {
          $response["error"] = TRUE;
                  $response["error_msg"] = "No Data Available ";
            echo json_encode($response);
        }



?>
