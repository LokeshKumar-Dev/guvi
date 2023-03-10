<?php
$collections = require_once __DIR__ . "/mongoDB.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

try {
    $POST_VAL = [];

    if (isset($_POST['name'])) {
        $POST_VAL['name'] = $_POST['name'];
    }
    if (isset($_POST['email'])) {
        $POST_VAL['email'] = $_POST['email'];
    }
    if (isset($_POST['last_name'])) {
        $POST_VAL['last_name'] = $_POST['last_name'];
    }
    if (isset($_POST['birthday'])) {
        $POST_VAL['birthday'] = $_POST['birthday'];
    }
    if (isset($_POST['number'])) {
        $POST_VAL['number'] = $_POST['number'];
    }
    //check POST values
    if(count($POST_VAL) < 0){
        $data = ['status' => 500, 'message' => 'Error: No Values'];
        echo json_encode($data);exit;
    }
    $id = intval($_POST['uId']);
    $POST_VAL['uId'] = $id;

    $document = array('$set' => $POST_VAL);

    $userUpdate = $collection->updateOne(array("uId" => $id), $document);
    $result = $collections->findOne(array("uId" => $id));
    echo $id;
    echo json_encode($result);exit;
    if ($userUpdate->getModifiedCount() > 0) {
        $result = $collections->findOne(array("uId" => $id));

        $data = ['status' => 200, 'uId' => $id, "exp" => $exp, "users" => $result];
        echo json_encode($data);
        exit;
    } else {
        $data = ['status' => 500, 'message' => 'Error: Not Mod'];
        echo json_encode($data);
    }

} catch (Exception $e) {
    $data = ['status' => 500, 'message' => 'Error: ' . $e->getMessage()];
    echo json_encode($data);
}
?>