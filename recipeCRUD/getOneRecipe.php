<?php
// Include configuration file
require_once '../config/config.php';
// What: Includes the configuration file that contains database settings and other configurations.
// Why: Required to access the database connection settings and other configurations necessary for the script.


// Get the PDO object
$pdo = getDBConnection();
// What: Calls a function to get a PDO object for database connection.
// Why: Establishes a connection to the database, which is necessary for performing database operations.


// Get POST data
$data = json_decode(file_get_contents("php://input"));
// What: Reads the raw POST data from the request body and decodes it from JSON format to a PHP object.
// Why: Allows the script to access the data sent in the request, typically from a frontend form or application.


// Initialize recipe model with the PDO object
require_once '../Models/recipeModel.php';
// What: Includes the Recipe model file.
// Why: Required to use the Recipe class and its methods for interacting with the recipes in the database.

$recipeModel = new Recipe($pdo);
// What: Creates a new instance of the Recipe class, passing the PDO object to the constructor.
// Why: Initializes the Recipe model with the database connection, allowing it to perform CRUD operations.


// Get one recipe by ID
$response = $recipeModel->getOneRecipe($data->id);
// What: Calls the getOneRecipe method on the Recipe model instance, passing the necessary data.
// Why: Retrieves a single recipe from the database using the data received in the POST request.


// Output response as JSON
echo json_encode($response);
// What: Encodes the response array as a JSON string and outputs it.
// Why: Sends a JSON response back to the client, which is a common format for API responses.
?>
