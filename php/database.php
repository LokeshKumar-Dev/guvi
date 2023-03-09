<?php

//CONFIG
$host = "localhost";
$dbname = "guvi";
$username = "root";
$password = "toor";

$mysqli = new mysqli(
hostname: $host,
username: $username,
password: $password,
database: $dbname
);

// Check Sql connection
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

// SQL create query
$sql_createTable = "CREATE TABLE IF NOT EXISTS `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) DEFAULT NULL,
    `pass` varchar(100) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
    )";

$exe = $mysqli->query($sql_createTable);
if (!$exe) {
    die("Sql error: " . $mysqli->error);
}

return $mysqli;