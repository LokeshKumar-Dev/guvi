<?php
// Include the required JWT library
require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$token = $_POST['token'];

//Secret Key 
session_start();
$secret_key = $_SESSION["secret"];

try {
    // Attempt to decode the JWT token
    $decoded_payload = JWT::decode($token, new Key($secret_key, 'HS256'));

    $id = $decoded_payload->uId;

    $data = ['status' => 200, 'uId' => $id];
    echo json_encode($data);
    exit;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>