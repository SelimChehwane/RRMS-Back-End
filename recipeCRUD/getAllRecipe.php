<?php
header('Content-Type: application/json');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Include configuration file
require_once '../config/config.php';
// What: Includes the configuration file that contains database settings and other configurations.
// Why: Required to access the database connection settings and other configurations necessary for the script.


// Get the PDO object
$pdo = getDBConnection();
// What: Calls a function to get a PDO object for database connection.
// Why: Establishes a connection to the database, which is necessary for performing database operations.


// Initialize recipe model with the PDO object
require_once '../Models/recipeModel.php';
// What: Includes the Recipe model file.
// Why: Required to use the Recipe class and its methods for interacting with the recipes in the database.

$recipeModel = new Recipe($pdo);
// What: Creates a new instance of the Recipe class, passing the PDO object to the constructor.
// Why: Initializes the Recipe model with the database connection, allowing it to perform CRUD operations.


// Get all recipes
$response = $recipeModel->getAllRecipe();
// What: Calls the getAllRecipe method on the Recipe model instance.
// Why: Retrieves all recipes from the database.


// Output response as JSON
echo json_encode($response);
// What: Encodes the response array as a JSON string and outputs it.
// Why: Sends a JSON response back to the client, which is a common format for API responses.
?>
