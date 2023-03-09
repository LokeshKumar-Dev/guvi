<?php
$collections = require_once __DIR__ . "/mongoDB.php";

// Insert user profile data into MongoDB
$result = $collection->insertOne([
    'username' => 'john_doe',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john_doe@example.com'
]);

// Check if the insert was successful
if ($result->getInsertedCount() > 0) {
    echo "Document inserted successfully";
    echo $result->getInsertedCount();
} else {
    echo "Document not inserted";
}

// // Retrieve user profile data from MongoDB
// $userProfileData = $collection->findOne([
//     'username' => 'john_doe'
// ]);

?>