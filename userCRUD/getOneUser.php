<?php

require_once '../config/config.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"));

require_once '../Models/userModel.php';

$userModel = new User($pdo);

$response = $userModel->getOneUser($data->id);

echo json_encode($response);
