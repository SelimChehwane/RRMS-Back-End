<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addUser($username, $password, $email, $user_type)
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)');
            $stmt->execute([$username, $password, $email, $user_type]);
            return ["message" => "User added successfully"];
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getAllUsers()
    {
        try {
            $stmt = $this->pdo->query('SELECT user_id, username, email, user_type FROM users');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getOneUser($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE user_id = ?');
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function updateUser($id, $username, $password, $email, $user_type)
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE users SET username = ?, password = ?, email = ?, user_type = ? WHERE user_id = ?');
            $stmt->execute([$username, $password, $email, $user_type, $id]);
            $rowCount = $stmt->rowCount();
            return [
                "message" => "User details updated successfully",
                "rowCount" => $rowCount
            ];
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function deleteUser($id)
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM users WHERE user_id = ?');
            $stmt->execute([$id]);
            return ["message" => "User deleted successfully"];
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
