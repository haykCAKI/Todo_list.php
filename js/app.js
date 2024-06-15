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



