<?php
session_start();

require '../db_connection.php';

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $postId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        
        $_SESSION['message'] = 'Eliminado correctamente';
        $_SESSION['message_type'] = 'success';
        header("Location: ../blogs.php");
        exit;
    } else {
        
        $_SESSION['message'] = 'No se pudo eliminar';
        $_SESSION['message_type'] = 'danger';
        header("Location: ../blogs.php");
        exit;
    }
} else {
    
    $_SESSION['message'] = "No se pudo eliminar";
    $_SESSION['message_type'] = "danger";
    header("Location: ../blogs.php");
    exit;
}
