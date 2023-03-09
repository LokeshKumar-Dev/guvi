<?php
// Include the required JWT library
require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1SWQiOjIzLCJuYW1lIjoidXNlcjIiLCJleHAiOjE2Nzg2Mjg4MzF9.114QchR5vJbsX6afGkugtJEjNrtFNBSSeOfbjYp1LWo';

//Secret Key 
session_start();
$secret_key = $_SESSION["secret"];

echo $secret_key;
try {
    // Attempt to decode the JWT token
    $decoded_payload = JWT::decode($token, new Key($secret_key, 'HS256'));
    print_r($decoded_payload);
    $id = $decoded_payload->uId;

    echo 'User ID: ' . $id . '<br>';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>