<?php

session_start();

/* if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; 
} */

require '../db_connection.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM usuarios WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if ($results !== false && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['id'];
        header("Location: ../blogs.php");
        exit; 
    } else {
        $_SESSION['message'] = 'Usuario no valido';
        $_SESSION['message_type'] = "danger";
        header("Location: ../index.php");
        exit;
    }
} else {
    $_SESSION['message'] = 'Aun no hay usuarios creados';
    $_SESSION['message_type'] = "danger";
    header("Location: ../index.php");
    exit;
}
?>
