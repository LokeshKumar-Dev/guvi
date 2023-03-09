<?php
require '../vendor/autoload.php';

// Connect to Redis using the default settings
$redis = new Predis\Client();
$secretKey = $redis->get('key');

if (!$secretKey) {
    //Secret Key for JWT sign
    $redis->set('key', "kbCf]w*mScZ>ARbzCu7q?^KBpzFzH1");
    // $redis->expire('user:123', 3600);
}

header('Location: ./../login.html');
?>