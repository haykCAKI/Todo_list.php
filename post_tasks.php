<?php

require 'db_conn.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->title)) {
        $title = htmlspecialchars(strip_tags($data->title));
        $description = htmlspecialchars(strip_tags($data->description ?? ''));

        try {
            $sql = "INSERT INTO tasks (title, description) VALUES (:title, :description)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->execute();

            echo json_encode(array("message" => "Tarefa criada com sucesso."));
        } catch(PDOException $e) {
            echo json_encode(array("message" => "Erro ao criar tarefa: " . $e->getMessage()));
        }
    } else {
        echo json_encode(array("message" => "Informe o título da tarefa."));
    }
}
?>
