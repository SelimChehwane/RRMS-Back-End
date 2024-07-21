<?php

require_once '../config/config.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"));

require_once '../Models/restaurantModel.php';

$restaurantModel = new Restaurant($pdo);

$response = $restaurantModel->deleteRestaurant($data->id);

echo json_encode($response);
