<?php
// Include the required JWT library
require_once '../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");

$database = $client->guvi;

// Get the list of collections in the database
$collections = $database->listCollections();

$exists = false;
foreach ($collections as $collection) {//Check Collection Exists
    if ($collection->getName() == "users") {
        $exists = true;
        break;
    }
}

if (!$exists) {// Create the collection
    $database->createCollection("users");
}

$collection = $database->users;

return $collection;