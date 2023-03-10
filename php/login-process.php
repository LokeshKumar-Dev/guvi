<?php
// Include the required JWT library
require_once '../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connect to Redis using the default settings
    $redis = new Predis\Client();

    $mysqli = require_once __DIR__ . "/database.php";

    $sql = "SELECT * FROM user WHERE email=?";

    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $mysqli->error);
    }
    $email = urldecode($_POST["user_email"]);

    //SQL
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc(); // fetch data

    if ($user) {

        if (password_verify($_POST["password"], $user["pass"])) {
            // Define the payload for the JWT
            $payload = array(
                'uId' => $user["id"],
                'name' => $user["name"],
                'exp' => time() + (60 * 60 * 24 * 3) // Expires in 3 days 
            );

            //Secret Key 
            $secret_key = $redis->get('key');

            // Generate the JWT token to sign the JWT
            $jwt_token = \Firebase\JWT\JWT::encode($payload, $secret_key, 'HS256');

            $data = ['status' => 200, 'token' => $jwt_token];

            // Sending JWT token
            echo json_encode($data);
            exit;
        }
        $data = ['status' => "300", 'message' => "Invalid Credentials"];
        echo json_encode($data);
        exit;
    }

    $data = ['status' => "400", 'message' => "User is not signed in"];

    echo json_encode($data);
}

?>