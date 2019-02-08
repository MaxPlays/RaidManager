<?php

  $host = "127.0.0.1";
  $port = 3306;
  $user = "root";
  $password = "";
  $database = "raidmanager";

  $conn = new mysqli($host, $user, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $conn->query("CREATE TABLE IF NOT EXISTS raids(id INT AUTO_INCREMENT, arena VARCHAR(300), pokemon VARCHAR(100), time LONG, timeformatted VARCHAR(8), lat FLOAT, lng FLOAT, participants INT DEFAULT 0, PRIMARY KEY(id));");

 ?>
