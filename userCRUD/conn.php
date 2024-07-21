<?php
  $db_server = "localhost";
  $db_user = "root";
  $password = "";
  $db_name = "rrms";
  
  try {
      $pdo = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      die(json_encode(["error" => "Connection failed: " . $e->getMessage()]));
  }
