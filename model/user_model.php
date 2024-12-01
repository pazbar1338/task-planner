<?php
require 'dbconn.php';




//comprueba si el email existe en la DB
function checkEmail($conn, $email) {
    $emailCount = 0;
    $query = $conn->prepare("SELECT COUNT(*) FROM users WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $query->bind_result($emailCount);
    $query->fetch();
    $query->close();
    return $emailCount > 0;
}

//creacion de usuario
function createUser($conn, $name, $email, $password) {
    $query = $conn->prepare("INSERT INTO users (Name, Email, Password) VALUES (?, ?, ?)");
    $query->bind_param("sss", $name, $email, $password);
    $result = $query->execute();
    $query->close();
    return $result;
}

//comprueba si la combinacion de email y contraseña coinciden en la BD
function checkLoginData($conn, $email, $password) {
    $query = $conn->prepare("SELECT Name, Email, Password, Id FROM users WHERE Email = ? AND Password = ?");
    $query->bind_param("ss", $email, $password);
    $query->execute();

    $isValid = $query->fetch();
    $query->close();

    return $isValid;
}


//obtiene todos los datos de un usuario a partir de su email
function getUserData($conn, $email) {
    $query = $conn->prepare("SELECT Name, Email, Password, Id FROM users WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();
    $userData = null;
    if ($row = $result->fetch_assoc()) {
        $userData = [
            'userName' => $row['Name'],
            'userEmail' => $row['Email'],
            'userPassword' => $row['Password'],
            'userId' => $row['Id'],
        ];
    }

    $query->close();
    return $userData;
}

// obtiene todos los Id y Nombre de la BD. Utilizado para poblar el selector de usuarios
function getUsers($conn) {
    $query = $conn->query("SELECT Id, Name FROM users");
    $users = [];
    
    if ($query) {
        while ($row = $query->fetch_object()) {
            $users[] = [
                'Id' => $row->Id,
                'Name' => $row->Name,
            ];
        }
    }
    
    return $users;
}


//obtiene el nombre de un usuario a partir de una id
function getUserNameById($conn, $userId) {
    $query = $conn->query("SELECT Name FROM users WHERE Id = $userId");
    return $query;
}

?>