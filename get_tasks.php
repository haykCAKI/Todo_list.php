<?php

require 'db_conn.php';

header("Content-Type: application/json");

try {
    // Query para selecionar todas as tarefas
    $sql = "SELECT * FROM tasks";
    $stmt = $conn->query($sql);

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tasks);
} catch(PDOException $e) {
    echo json_encode(array("message" => "Erro ao buscar tarefas: " . $e->getMessage()));
}
?>
