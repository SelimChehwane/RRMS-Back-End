<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request method. Only POST requests are allowed."]);
    exit();
}

require_once '../config/config.php';


$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    die(json_encode(["error" => "Invalid JSON received."]));
}

file_put_contents('php://stderr', print_r($data, true)); 

if (!isset($data['email'], $data['password'], $data['username'])) {
    echo json_encode(["error" => "Incomplete data provided."]);
    exit();
}

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;
$username = $data['username'] ?? null;
$user_type =$data['user_type']??null;

if ($email === null || $password === null || $username === null||$user_type===null) {
    echo json_encode(["error" => "One or more fields are missing."]);
    exit();
}

$password = password_hash($password, PASSWORD_DEFAULT); 

$sql = "INSERT INTO users (email, password, username, user_type) VALUES (:email, :password, :username, :user_type)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':email' => $email,
        ':password' => $password,
        ':username' => $username,
        'user_type' => $user_type
    ]);
    echo json_encode(["message" => "Account created successfully!"]);
} catch (PDOException $e) {
    echo json_encode([
        "error" => "Execute failed: " . $e->getMessage(),
        "sqlstate" => $e->getCode(),
        "email" => $email,
        "username" => $username
    ]);
}

$pdo = null; 
?>