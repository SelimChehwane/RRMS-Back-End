<?php
require_once '../config/config.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$user_type = $data['user_type'];
$restaurant_name = $data['restaurant_name'] ?? null;
$restaurant_location = $data['restaurant_location'] ?? null;

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $email, $password, $user_type]);
    $user_id = $pdo->lastInsertId();

    if ($user_type === 'owner' && $restaurant_name && $restaurant_location) {
        $stmt = $pdo->prepare('INSERT INTO restaurants (name, location, owner_id) VALUES (?, ?, ?)');
        $stmt->execute([$restaurant_name, $restaurant_location, $user_id]);
    }

    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
