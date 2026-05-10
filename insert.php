<?php
// Set headers to return JSON and allow requests
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// Step 1: Connect to the database
require 'db.php';

// Step 2: Get the raw POST data from the fetch() request
$inputData = file_get_contents("php://input");
$data = json_decode($inputData, true);

// Step 3: Backend Validation (Requirement #3)
if (empty($data['name']) || empty($data['email']) || empty($data['password']) || empty($data['role'])) {
    echo json_encode(["status" => "error", "message" => "All fields are required!"]);
    exit;
}

$name = strip_tags($data['name']);
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$password = $data['password']; 
$role = $data['role'];

try {
    // Logic 1: Prevent Duplicate Emails (Requirement #2)
    $emailCheck = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $emailCheck->execute([$email]);
    if ($emailCheck->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "This email is already registered!"]);
        exit;
    }

    // Logic 2: Only ONE Admin allowed (Requirement #1)
    if ($role === 'admin') {
        $adminCheck = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
        if ($adminCheck > 0) {
            echo json_encode(["status" => "error", "message" => "Registration Error: Only one admin is allowed in the system."]);
            exit;
        }
    }

    // Step 4: Secure the password (Requirement: Real-world constraints)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Step 5: Save to Database
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$name, $email, $hashedPassword, $role])) {
        echo json_encode(["status" => "success", "message" => "User registered successfully!"]);
    }

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>