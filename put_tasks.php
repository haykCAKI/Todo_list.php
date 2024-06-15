<?php

require 'db_conn.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $taskId = isset($_GET['id']) ? $_GET['id'] : die();
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->title)) {
        $title = htmlspecialchars(strip_tags($data->title));
        $description = htmlspecialchars(strip_tags($data->description ?? ''));

        try {
            $sql = "UPDATE tasks SET title = :title, description = :description WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id', $taskId);
            $stmt->execute();

            echo json_encode(array("message" => "Tarefa atualizada com sucesso."));
        } catch(PDOException $e) {
            echo json_encode(array("message" => "Erro ao atualizar tarefa: " . $e->getMessage()));
        }
    } else {
        echo json_encode(array("message" => "Informe o título da tarefa."));
    }
}
?>
