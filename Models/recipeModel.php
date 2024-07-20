<?php
class Recipe
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addRecipe($name, $cuisine_type, $description, $instructions)
    {
        $stmt = $this->pdo->prepare('INSERT INTO recipes (name, cuisine_type, descripton, instructions) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $cuisine_type, $description, $instructions]);
        return ["message" => "recipe added successfully"];
    }

    public function getAllRecipe()
    {
        $stmt = $this->pdo->query('SELECT * FROM recipes');
        return $stmt->fetchAll();
    }

    public function getOneRecipe($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM recipes WHERE restaurant_id = ?');
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Only get associative array results
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function updateRecipe($id, $name, $cuisine_type, $description, $instructions)
    {
        $stmt = $this->pdo->prepare('UPDATE recipes SET name = ?, cuisine_type = ?, description = ?, instructions = ? WHERE recipe_id = ?');
        $stmt->execute([$id, $name, $cuisine_type, $description, $instructions]);

        // Debugging: Get rowCount
        $rowCount = $stmt->rowCount();
        return [
            "message" => "recipe details updated successfully",
            "rowCount" => $rowCount
        ];
    }

    public function deleteRecipe($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM recipes WHERE recipe_id = ?');
        $stmt->execute([$id]);
        return ["message" => "recipe deleted successfully"];
    }
}
