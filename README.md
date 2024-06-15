Herick Akio Yoshii Kumata

<h3>Aplicativo de de lista de tarefas (To-do List) desenvolvito com PHP, MySQL, HTML e CSS
e JavaScript (AJAX). O aplicativo permite criar, ler, atualizar e deletar tarefas (CRUD).</h3>

<h1>Estrutura do Projeto</h1>

todo-list/
<br>
│── create_task.php
<br>
│── delete_task.php
<br>
│── get_tasks.php
<br>
│── update_task.php
<br>
├── db_schema.sql
<br>
├── db_conn.php
<br>
├── index.php
<br>
└── README.md
<br>
├── css/<br>
│   └── style.css<br>
├── js/<br>
│   └── app.js
______________________________________________________________________________________

<h1>Configuração do Ambiente</h1>

<h2>Requisitos</h2>
<ul>
  <li>XAMPP ou WAMP (para o servidor Apache e MySQL)</li>
  <li>Navegador web</li>
  <li>Git</li>
</ul>
______________________________________________________________________________________

<h2>Passos para Configuração</h2>

<ol>
  <li>Clone o Repositório:</li>
  <p>Clonar o respositório para o ambiente local usando comando</p>
  <p>
    git clone https://github.com/seu-usuario/todo-list.git
    <br>
    cd todo-list
  </p>
  <br>
 <li>Configuração do Servidor</li>
 <p>Certifique-se de que o servidor Apache e MySQL estevam ativos XAMPP ou WAMP</p>
 <br>
  <li>Configuração do Banco de Dados</li>
  <ul>
    <li>phpMyAdmin: http://localhost/phpmyadmin</li>
    <li>banco de dados: <strong>todo_list</strong></li>
    <li>Import file: <strong>db_schema.sql</strong></li>
  </ul>
  <li>Configuração do Projeto</li>
  <ul>
    <li>Mover o projeto clonado para o diretório 
      <strong>`htdocs`</strong> do XAMPP ou <strong>`www`</strong> do WAMP
    </li>
    <li> 
      Navegador: http://localhost/todo/index.php
    </li>
  </ul>
</ol>
______________________________________________________________________________________

<h1>Estrutura dos Arquivos</h1>
<ul>
  <li><strong>db_schema.sql</strong></li>


```php
<?php
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "todo_list";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
```
<li><strong>db_conn.php</strong></li>
<p>Arquivo de conexão ao banco de dados</p>

```php
<?php
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "todo_list";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
```
<li><strong>post_tasks.php</strong></li>
<p>Api para criar nova tarefa:</p>

```php
<?php
require '../db_conn.php';
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
            echo json_encode(["message" => "Tarefa criada com sucesso."]);
        } catch(PDOException $e) {
            echo json_encode(["message" => "Erro ao criar tarefa: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["message" => "Informe o título da tarefa."]);
    }
}
?>
```

<li><strong>delete_tasks.php</strong></li>
<p>Api para deletar tarefa:</p>

```php
<?php
require '../db_conn.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $taskId = isset($_GET['id']) ? $_GET['id'] : die();
    try {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(["message" => "Tarefa deletada com sucesso."]);
    } catch(PDOException $e) {
        echo json_encode(["message" => "Erro ao deletar tarefa: " . $e->getMessage()]);
    }
}
?>
```
<li><strong>get_tasks.php</strong></li>
<p>API para obter todas as tarefas:</p>

```php
<?php
require '../db_conn.php';
header("Content-Type: application/json");

try {
    $sql = "SELECT * FROM tasks";
    $stmt = $conn->query($sql);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
} catch(PDOException $e) {
    echo json_encode(["message" => "Erro ao buscar tarefas: " . $e->getMessage()]);
}
?>
```
<li><strong>update_tasks.php</strong></li>
<p>API para atualizar uma tarefa:</p>

```php
<?php
require '../db_conn.php';
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
            echo json_encode(["message" => "Tarefa atualizada com sucesso."]);
        } catch(PDOException $e) {
            echo json_encode(["message" => "Erro ao atualizar tarefa: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["message" => "Informe o título da tarefa."]);
    }
}
?>
```
<li><strong>js/app.js</strong></li>
<p>Arquivo para manipulação do DOM e chamadas AJAX:</p>

```php
// app.js

document.addEventListener('DOMContentLoaded', function() {
   fetchTasks();
});

function fetchTasks() {
   fetch('get_tasks.php')
   .then(response => response.json())
   .then(tasks => {
       const taskList = document.getElementById('taskList');
       taskList.innerHTML = ''; 

       tasks.forEach(task => {
           const taskItem = `
               <div class="todo-item">
                   <h2>${task.title}</h2>
                   <p>${task.description}</p>
                   <div>
                       <button class="btn-delete" data-id="${task.id}">Deletar</button>
                       <button class="btn-update" data-id="${task.id}">Atualizar</button>
                   </div>
               </div>
           `;
           taskList.innerHTML += taskItem;
       });

       document.querySelectorAll('.btn-delete').forEach(btn => {
           btn.addEventListener('click', deleteTask);
       });
       document.querySelectorAll('.btn-update').forEach(btn => {
           btn.addEventListener('click', updateTask);
       });
   })
   .catch(error => {
       console.error('Erro ao buscar tarefas:', error);
   });
}

document.getElementById('addForm').addEventListener('submit', function(event) {
   event.preventDefault();

   const title = document.getElementById('title').value;
   const description = document.getElementById('description').value;

   if (title.trim() === '') {
       alert('Por favor, insira um título para a tarefa.');
       return;
   }

   const data = {
       title: title,
       description: description
   };

   fetch('post_tasks.php', {
       method: 'POST',
       headers: {
           'Content-Type': 'application/json'
       },
       body: JSON.stringify(data)
   })
   .then(response => response.json())
   .then(data => {
       if (data.message === "Tarefa criada com sucesso.") {
           document.getElementById('title').value = '';
           document.getElementById('description').value = '';
           fetchTasks();
       } else {
           alert('Erro ao adicionar tarefa: ' + data.message);
       }
   })
   .catch(error => {
       console.error('Erro ao adicionar tarefa:', error);
   });
});

function updateTask(event) {
   const taskId = event.target.getAttribute('data-id');
   const title = prompt('Digite o novo título para esta tarefa:');
   const description = prompt('Digite a nova descrição para esta tarefa:');

   if (title === null || description === null) {
       return;
   }

   const data = {
       title: title,
       description: description
   };

   fetch(`put_tasks.php?id=${taskId}`, {
       method: 'PUT',
       headers: {
           'Content-Type': 'application/json'
       },
       body: JSON.stringify(data)
   })
   .then(response => response.json())
   .then(data => {
       alert(data.message);
       fetchTasks(); 
   })
   .catch(error => {
       console.error('Erro ao atualizar tarefa:', error);
   });
}

function deleteTask(event) {
   const taskId = event.target.getAttribute('data-id');
   if (!confirm('Tem certeza que deseja excluir esta tarefa?')) {
       return;
   }

   fetch(`delete_tasks.php?id=${taskId}`, {
       method: 'DELETE'
   })
   .then(response => response.json())
   .then(data => {
       alert(data.message);
       fetchTasks(); 
   })
   .catch(error => {
       console.error('Erro ao excluir tarefa:', error);
   });
}
```
<li><strong>index.php</strong></li>
<p>HTML main</p>

```html
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
            <!-- Tarefas serão carregadas dinamicamente aqui -->
        </div>
    </div>
    <script src="js/app.js"></script>
</body>
</html>
```

</ul>


