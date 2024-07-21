<?php

class Recipe
{
    // Declare a private variable to hold the PDO instance
    private $pdo;
    // This variable is used to store the database connection object (PDO) that will be used for database operations.
    // It's private to restrict direct access from outside the class, ensuring encapsulation.

    // Constructor method to initialize the PDO instance
    // A constructor is a special method in a class that is automatically called when an object of that class is created. 
    // Its primary purpose is to initialize the object's properties.
    public function __construct($pdo)
    {
        // Assign the passed PDO instance to the private variable
        $this->pdo = $pdo;
        // The constructor initializes the $pdo property with the PDO instance passed as a parameter when the class is instantiated.
        // This sets up the connection for use in other methods, ensuring the class can interact with the database.
    }

    // Method to add a new recipe to the database
    public function addRecipe($name, $cuisine_type, $description, $instructions, $restaurant_id)
    {
        // Prepare an SQL statement to insert a new recipe
        $stmt = $this->pdo->prepare('INSERT INTO recipes (name, cuisine_type, description, instructions, restaurant_id) VALUES (?, ?, ?, ?, ?)');
        // Prepared statements help prevent SQL injection by separating the query structure from the data.

        // Execute the prepared statement with the provided data
        $stmt->execute([$name, $cuisine_type, $description, $instructions, $restaurant_id]);
        // The execute method binds the provided data to the placeholders in the prepared statement,
        // securely inserting the new recipe into the database.

        // Return a success message
        return ["message" => "recipe added successfully"];
        // Returning a success message provides feedback that the recipe was added successfully.
    }

    // Method to retrieve all recipes from the database
    public function getAllRecipe()
    {
        // Execute a query to select all records from the recipes table
        $stmt = $this->pdo->query('SELECT recipe_id, name, cuisine_type, description, instructions, restaurant_id FROM recipes');
        // This line executes a simple SQL query to retrieve all records from the recipes table,
        // allowing the retrieval of all recipes in the database.

        // Fetch and return all records as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // The results of the query are fetched and returned as an associative array,
        // avoiding duplication by not including numeric indices.
    }

    // Method to retrieve a single recipe by its ID
    public function getOneRecipe($id)
    {
        try {
            // Prepare an SQL statement to select a recipe by its ID
            $stmt = $this->pdo->prepare('SELECT * FROM recipes WHERE recipe_id = ?');
            // Preparing the SQL statement with a placeholder for the recipe ID helps prevent SQL injection
            // by safely binding the user input.

            // Execute the prepared statement with the provided ID
            $stmt->execute([$id]);
            // The execute method binds the provided ID to the placeholder,
            // ensuring the query retrieves the correct recipe.

            // Fetch and return the record as an associative array
            return $stmt->fetch(PDO::FETCH_ASSOC);
            // Fetching the result as an associative array makes it easier to access the data by column names.

        } catch (PDOException $e) {
            // Return an error message if an exception occurs
            return "Error: " . $e->getMessage();
            // Catching and returning an error message helps with debugging and provides feedback if something goes wrong.
        }
    }

    // Method to update an existing recipe in the database
    public function updateRecipe($id, $name, $cuisine_type, $description, $instructions)
    {
        try {
            // Prepare an SQL statement to update a recipe
            $stmt = $this->pdo->prepare('UPDATE recipes SET name = ?, cuisine_type = ?, description = ?, instructions = ? WHERE recipe_id = ?');
            // Using a prepared statement helps prevent SQL injection by safely binding the user input.

            // Execute the prepared statement with the provided data
            $stmt->execute([$name, $cuisine_type, $description, $instructions, $id]);
            // The execute method binds the provided data to the placeholders,
            // ensuring the recipe is updated with the correct values.

            // Get the number of affected rows
            $rowCount = $stmt->rowCount();
            // Getting the row count helps confirm that the update operation affected the expected number of rows.

            // Return a success message along with the number of updated rows
            return [
                "message" => "recipe details updated successfully",
                "rowCount" => $rowCount
            ];
            // Returning a success message along with the row count provides feedback on the update operation's success.
        } catch (PDOException $e) {
            // Return an error message if an exception occurs
            return "Error: " . $e->getMessage();
            // Catching and returning an error message helps with debugging and provides feedback if something goes wrong.
        }
    }

    // Method to delete a recipe from the database
    public function deleteRecipe($id)
    {
        try {
            // Prepare an SQL statement to delete a recipe by its ID
            $stmt = $this->pdo->prepare('DELETE FROM recipes WHERE recipe_id = ?');
            // Using a prepared statement helps prevent SQL injection by safely binding the user input.

            // Execute the prepared statement with the provided ID
            $stmt->execute([$id]);
            // The execute method binds the provided ID to the placeholder,
            // ensuring the correct recipe is deleted.

            // Return a success message
            return ["message" => "recipe deleted successfully"];
            // Returning a success message provides feedback that the recipe was deleted successfully.
        } catch (PDOException $e) {
            // Return an error message if an exception occurs
            return "Error: " . $e->getMessage();
            // Catching and returning an error message helps with debugging and provides feedback if something goes wrong.
        }
    }
}
