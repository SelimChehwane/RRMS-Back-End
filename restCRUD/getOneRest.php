<?php

require_once '../config/config.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"));

require_once '../Models/restModel.php';

$restaurantModel = new Restaurant($pdo);

$response = $restaurantModel->getOneRestaurant($data->id);

echo json_encode($response);
