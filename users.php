<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Step 1: Connect to the database
require 'db.php';

try {
    // Step 2: Check if a filter is requested (Requirement #4)
    $roleFilter = isset($_GET['role']) ? $_GET['role'] : null;

    if ($roleFilter === 'admin') {
        // Fetch only admins
        $stmt = $pdo->prepare("SELECT name, email, role FROM users WHERE role = 'admin' ORDER BY id DESC");
    } else {
        // Fetch everyone
        $stmt = $pdo->prepare("SELECT name, email, role FROM users ORDER BY id DESC");
    }

    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Step 3: Return the result as JSON
    echo json_encode($users);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>