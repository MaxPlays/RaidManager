<?php

  if(isset($_POST["id"]) && isset($_POST["number"])){
    include("sql.php");
    $stmt = $conn->prepare("UPDATE raids SET participants = participants + ? WHERE id=?;");
    $stmt->bind_param("ii", $number, $id);

    $number = $_POST["number"];
    $id = $_POST["id"];

    $stmt->execute();

    echo("The number of participants has been increased");

    $conn->close();
  }else{
    echo("Error");
  }

 ?>
