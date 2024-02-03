<?php
session_start();

require '../db_connection.php';

if (isset($_POST['content']) && !empty(trim($_POST['content'])) && isset($_SESSION['user_id'])) {
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id']; 

    

    $sql = "INSERT INTO posts (user_id, content) VALUES (:user_id, :content)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        
        $_SESSION['message'] = "Publicación creada con éxito.";
        $_SESSION['message_type'] = "success";
        header("Location: ../blogs.php");
        exit;
    } else {
        $_SESSION['message'] = "Hubo un error al crear la publicación.";
        $_SESSION['message_type'] = "danger";
        header("Location: ../blogs.php");
        exit;
    }
} else {
    
    $_SESSION['message'] = "Por favor, introduce contenido en la publicación.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../blogs.php");
    exit;
}
