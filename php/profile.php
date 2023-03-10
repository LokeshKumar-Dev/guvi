<?php
// Include the required JWT library
require_once '../vendor/autoload.php';

$collections = require_once __DIR__ . "/mongoDB.php";
$mysqli = require_once __DIR__ . "/database.php";

$sql = "SELECT * FROM user WHERE id=?";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $mysqli->error);
}

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$token = $_POST['token'];

// Connect to Redis using the default settings
$redis = new Predis\Client();

//Secret Key 
$secret_key = $redis->get("key");

if (!$secret_key) {
    echo json_encode(['status' => 500, 'message' => "Sry Internal Server Error"]);
    exit;
}

try {
    // Attempt to decode the JWT token
    $decoded_payload = JWT::decode($token, new Key($secret_key, 'HS256'));

    $id = $decoded_payload->uId;
    $exp = $decoded_payload->exp;
    // Math.round(Date.now()/1000)

    //SQL
    $stmt->bind_param("s", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc(); // fetch data

    $document = ['uId' => $id, 'name' => $user["name"], 'email' => $user["email"]];
    // $document = ['uId' => $id, 'name' => "loki", 'last_name' => "m", "birthday" => "10/20/2022", "number" => "9840545063",];

    $result = $collections->findOne(array("uId" => $id));

    // If the document doesn't exist, insert it using insertOne()
    if (!$result) {
        $insertResult = $collection->insertOne($document);

        // Check if the insert was successful
        if ($insertResult->getInsertedCount() > 0) {
            $data = ['status' => 200, 'uId' => $id, "users" => $document];
            echo json_encode($data);
            exit;
        } else {
            $data = ['status' => 500, 'message' => 'Error: ' . "Document not inserted"];
            echo json_encode($data);
            exit;
        }
    }

    $data = ['status' => 200, 'uId' => $id, "users" => $result];
    echo json_encode($data);
    exit;
} catch (Exception $e) {
    $data = ['status' => 500, 'message' => 'Error: ' . $e->getMessage()];
    echo json_encode($data);
}
?>