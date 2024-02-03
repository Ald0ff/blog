<?php
session_start();
include("../db_connection.php");

if (isset($_POST['update'])) {
    $id = $_POST["id"];
    
    if (isset($_POST['content']) && !empty(trim($_POST['content']))) {
        $content = trim($_POST['content']);

      
        $query = $conn->prepare("UPDATE posts SET content = ? WHERE id = ?");
        $query->bindParam(1, $content, PDO::PARAM_STR);
        $query->bindParam(2, $id, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['message'] = "Post actualizado";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "El contenido no puede estar vacío";
        $_SESSION['message_type'] = 'warning';
    }
    header("Location: ../perfil.php");
    $query->execute();
}
