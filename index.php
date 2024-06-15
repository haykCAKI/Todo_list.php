<?php require 'db_conn.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
   <title>To-Do List</title>
</head>
<body>
   <div class="main-section">
      <div class="add-section">
         <form id="addForm">
            <input type="text" name="title" id="title" placeholder="Digite o título da tarefa">
            <textarea name="description" id="description" placeholder="Digite a descrição da tarefa"></textarea>
            <button type="submit">Add &nbsp; <span>&#43;</span></button>
         </form>
      </div>
      <div class="show-todo-section" id="taskList">
         <div class="todo-item">
            <h2>To do Exemple</h2>
            <p>Todo Exemple Descrição</p>
            <div>
               <button class="btn-delete" data-id="${task.id}">Deletar</button>
               <button class="btn-update" data-id="${task.id}">Atualizar</button>
            </div>
         </div>
      </div>
   </div>

   <script src="js/app.js"></script>
</body>
</html>
