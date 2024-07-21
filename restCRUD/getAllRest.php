<?php

require_once '../config/config.php';

$pdo = getDBConnection();

require_once '../Models/restaurantModel.php';

$restaurantModel = new Restaurant($pdo);

$response = $restaurantModel->getAllRestaurants();

echo json_encode($response);
