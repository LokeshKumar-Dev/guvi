<?php

session_start();

//Secret Key for JWT sign
$_SESSION["secret"] = "kbCf]w*mScZ>ARbzCu7q?^KBpzFzH1";

$mysqli = require_once __DIR__ . "/database.php";

header('Location: ./../login.html');
    ?>