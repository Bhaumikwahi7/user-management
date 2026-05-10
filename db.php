<?php
$host = 'sql211.infinityfree.com'; // Get this from your InfinityFree MySQL page
$dbname = 'if0_41883087_user_management_db';   // Get this from your InfinityFree MySQL page
$username = 'if0_41883087';          // Get this from your InfinityFree MySQL page
$password = 'NIgyyuLNiAEm1T'; // Your InfinityFree account password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}
?>
