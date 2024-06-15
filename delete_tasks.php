<?php

require 'db_conn.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $taskId = isset($_GET['id']) ? $_GET['id'] : die();

    try {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();

        echo json_encode(array("message" => "Tarefa deletada com sucesso."));
    } catch(PDOException $e) {
        echo json_encode(array("message" => "Erro ao deletar tarefa: " . $e->getMessage()));
    }
}
?>
