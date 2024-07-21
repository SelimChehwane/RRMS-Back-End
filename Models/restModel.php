<?php

class Restaurant
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addRestaurant($name, $location, $owner_id)
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO restaurants (name, location, owner_id) VALUES (?, ?, ?)');
            $stmt->execute([$name, $location, $owner_id]);
            return ["message" => "restaurant added successfully"];
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getAllRestaurants()
    {
        try {
            $stmt = $this->pdo->query('SELECT restaurant_id, name, location, owner_id FROM restaurants');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getOneRestaurant($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM restaurants WHERE restaurant_id = ?');
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function updateRestaurant($id, $name, $location, $owner_id)
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE restaurants SET name = ?, location = ?, owner_id = ? WHERE restaurant_id = ?');
            $stmt->execute([$name, $location, $owner_id, $id]);
            $rowCount = $stmt->rowCount();
            return [
                "message" => "restaurant details updated successfully",
                "rowCount" => $rowCount
            ];
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function deleteRestaurant($id)
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM restaurants WHERE restaurant_id = ?');
            $stmt->execute([$id]);
            return ["message" => "restaurant deleted successfully"];
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
