<?php
// Include the required JWT library
require_once '../vendor/autoload.php';

$collections = require_once __DIR__ . "/mongoDB.php";

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
    
    $data = ['status' => 200, 'uId' => $id];
    echo json_encode($data);
    exit;
} catch (Exception $e) {
    $data = ['status' => 500, 'message' => 'Error: ' . $e->getMessage()];
    echo json_encode($data);
}
?>