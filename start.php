<?php

  if(isset($_POST["arena"]) && isset($_POST["pokemon"]) && isset($_POST["time"]) && isset($_POST["lat"]) && isset($_POST["lng"])){

    include("sql.php");

    $stmt = $conn->prepare("INSERT INTO raids(arena, pokemon, time, timeformatted, lat, lng) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisdd", $arena, $pokemon, $time, $timeformatted, $lat, $lng);

    date_default_timezone_set("Europe/Berlin");

    $arena = $_POST["arena"];
    $pokemon = $_POST["pokemon"];
    $time = date_timestamp_get(date_create($_POST["time"]));
    $timeformatted = $_POST["time"];
    $lat = $_POST["lat"];
    $lng = $_POST["lng"];

    if($time < date_timestamp_get(date_create())){
      die("Error");
    }
    if($lat > 49.51451 || $lat < 49.381479 || $lng < 10.444022 || $lng > 11.226654){
      die("Error");
    }

    $stmt->execute();

    echo("The raid has been started");

    $conn->close();
  }else{
    echo("Error");
  }

 ?>
