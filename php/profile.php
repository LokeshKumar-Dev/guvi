<?php
// Include the required JWT library
require_once '../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$token = $_POST['token'];

//Secret Key 
session_start();
$secret_key = $_SESSION["secret"];

try {
    // Attempt to decode the JWT token
    $decoded_payload = \Firebase\JWT\JWT::decode($token, $secret_key);

    $id = $decoded_payload->uId;

    echo 'User ID: ' . $id . '<br>';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>