<?php
$val = $_POST;

if (empty($_POST["user_name"])) {
    die("Name is required");
}

if (!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirm"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, pass)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "sss",
    $_POST["user_name"],
    $_POST["user_email"],
    $password_hash
);

if ($stmt->execute()) {

    // include("./../signup-success.html");
    exit('1');

} else {
    if ($mysqli->errno === 1062) {
        exit('2');
    } else {
        exit('4');
    }
}