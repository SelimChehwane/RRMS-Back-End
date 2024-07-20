<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'rrms');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDBConnection()
{
    $conn = null;
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        //error catching net
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //ie: set up exception for error 
    } catch (PDOException $e) {
        //if error is caught:
        echo "Connection Failed: " . $e->getMessage();
        return null;
    }
    return $conn;
}

$pdo = getDBConnection();

?>
