<?php
session_start(); 

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require("/xampp/htdocs/api/conn.php");

file_put_contents('php://stderr', print_r($_GET, true)); 

$email = $_GET['email'] ?? null;
$password = $_GET['password'] ?? null;

if ($email === null || $password === null) {
    echo json_encode(["error" => "One or more fields are missing."]);
    exit();
}


$sql = "SELECT * FROM Users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    
    $_SESSION['user_type'] = $user['user_type'];
    $_SESSION['logged_in'] = true;

    echo json_encode([
        "message" => "Login successful!",
        "user_type" => $user['user_type'] 
    ]);
} else {
    echo json_encode(["error" => "Invalid email or password."]);
}

$pdo = null; 
?>