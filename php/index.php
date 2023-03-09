<?php

session_start();

//Secret Key for JWT sign
$_SESSION["secret"] = "kbCf]w*mScZ>ARbzCu7q?^KBpzFzH1";

$mysqli = require_once __DIR__ . "/database.php";

if (isset($_SESSION["user_id"])) {

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

include("./../home.html")
    ?>