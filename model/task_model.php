<?php
require 'dbconn.php';

/*Funciones a la BD relacionadas con las tareas.
Cuando el input viene del usuario se ha utilizado prepare() por seguridad.
Para las demas se ha utilizado query() para simplificar*/


//obtiene las tareas creadas por un id de usuario
function getCreatedTasks($conn, $userId) {
    $query = $conn->query("SELECT Id, Title, Description, Due_date, completed FROM task WHERE Created_by = $userId");
    return $query;
}

//obtiene las tareas asignadas a un id de usuario
function getAssignedTasks($conn, $userId) {
    $query = $conn->query("SELECT Title, Description, Due_date, created_by, completed, Id FROM task WHERE Id IN (SELECT task_id FROM task_users WHERE user_id = $userId)");
    return $query;
}

//cambia el campo 'completed' a 1 (por defecto es 0)
function markTaskComplete($conn, $taskId) {
    $query = $conn->query("UPDATE task SET completed = 1 WHERE Id = $taskId");
    return $query; 
}

//obtiene los usuarios asignados a la id de una tarea
function getAssignedUsers($conn, $taskId) {
    $query = $conn->query("SELECT Id, Name FROM users WHERE Id IN (SELECT user_id FROM task_users WHERE task_id = $taskId)");
    return $query;
}

//creacion de la tarea, primero crea la tarea en la tabla task y luego en la tabla task_users relaciona la id de la recien creada tarea a los usuarios seleccionados
function createTask($title, $description, $dueDate, $createdBy, $usersToTask, $conn) { 
    $taskQuery = $conn->prepare("INSERT INTO task (Title, Description, Due_date, Created_by) VALUES (?, ?, ?, ?)");
    $taskQuery->bind_param("sssi", $title, $description, $dueDate, $createdBy);
     
    if ($taskQuery->execute()) {
    
        $taskId = $conn->insert_id; //asigna a $taskId la id de la ultima tarea creada
        $taskQuery->close();

        if ($usersToTask) {
            //asigna usuarios a la tareada anteriormente creada
            $userTaskQuery = $conn->prepare("INSERT INTO task_users (user_id, task_id) VALUES (?, ?)");

            foreach ($usersToTask as $userId) {
                $userTaskQuery->bind_param("ii", $userId, $taskId);
                $userTaskQuery->execute();
            }
            $userTaskQuery->close();
        }
        
        return $taskId;
    }
    $taskQuery->close();

    return false;
}

//obtiene informacion de la tarea a partir de una id. Utiliza prepare() porque $taskId viene de la URL y podria ser manipulada
function getTaskById($conn, $taskId) {
    $query = $conn->prepare("SELECT Title, Description, Due_date FROM task WHERE Id = ?"); 
    $query->bind_param('i', $taskId);
    $query->execute();
    $result = $query->get_result();
    $task = $result->fetch_assoc();
    $query->close();
    return $task;
}

//actualizar tarea
function updateTask($conn, $taskId, $title, $description, $dueDate, $assignedUsers) {
    //actualiza los valores de la tarea en la tabla task
    $updateQuery = $conn->prepare("UPDATE task SET Title = ?, Description = ?, Due_date = ? WHERE Id = ?");
    $updateQuery->bind_param('sssi', $title, $description, $dueDate, $taskId);
    $updateQuery->execute();
    $updateQuery->close();

    //elimina a los usuarios asociados a la tarea en la tabla que asocia a los usuarios y las tareas (task_users)
    $deleteQuery = $conn->prepare("DELETE FROM task_users WHERE task_id = ?");
    $deleteQuery->bind_param('i', $taskId);
    $deleteQuery->execute();
    $deleteQuery->close();

    //añade los usuarios a la tarea que se va a actualizar en la tabla task_users
    $insertQuery = $conn->prepare("INSERT INTO task_users (task_id, user_id) VALUES (?, ?)");
    foreach($assignedUsers as $userId) {
        $insertQuery->bind_param('ii', $taskId, $userId);
        $insertQuery->execute();
       
    }
    $insertQuery->close();

    return true;
}

//funciones delete_task

//$taskId viene de URL
function getTaskCreatedBy($conn, $taskId) {
    $query = $conn->prepare("SELECT created_by FROM task WHERE Id = ?");
    $query->bind_param('i', $taskId);  
    $query->execute();
    $result = $query->get_result();
    return $result;
}

function deleteAssignedUsers($conn, $taskId) {
    $query = $conn->query("DELETE FROM task_users WHERE task_id = $taskId");
    return $query;
}

function deleteTask($conn, $taskId) {
    $query = $conn->query("DELETE FROM task WHERE Id = $taskId");
    return $query;
}

?>