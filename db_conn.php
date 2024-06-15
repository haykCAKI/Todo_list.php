<?php

$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "todo_list";

try {
  
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
} catch(PDOException $e) {

    echo json_encode(array("message" => "Falha na conexão: " . $e->getMessage()));
    exit();
}
?>
