<?php

require_once '../config/config.php';

$pdo = getDBConnection();

require_once '../Models/userModel.php';

$userModel = new User($pdo);

$response = $userModel->getAllUsers();

echo json_encode($response);
