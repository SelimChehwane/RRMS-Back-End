<?php
// Include configuration file
require_once '../../config/config.php';

// Get the PDO object
$pdo = getDBConnection();

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Initialize recipe model with the PDO object
require_once '../../models/recipeModel.php';
$recipeModel = new Recipe($pdo);

// Example of adding a recipe
$response = $hotelModel->addRecipe($data->name, $data->cuisine_type, $data->description, $data->instructions);

// Output response as JSON
echo json_encode($response);
