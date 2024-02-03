<?php
session_start();

require '../db_connection.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nombre']) && !empty($_FILES['foto']['name'])) {
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['message'] = 'Este correo electrónico ya está registrado.';
        $_SESSION['message_type'] = "danger";
        header("Location: ../vistas/signup.php");
        exit;
    }

    
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->execute();
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['message'] = 'Este nombre de usuario ya está en uso.';
        $_SESSION['message_type'] = "danger";
        header("Location: ../vistas/signup.php");
        exit;
    }

    
    $sql = "INSERT INTO usuarios (email, password, nombre, foto) VALUES (:email, :password, :nombre, :foto)";
    $stmt = $conn->prepare($sql);

    
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':nombre', $_POST['nombre']);

    
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    
    $basename = basename($_FILES["foto"]["name"]);
    $imageFileType = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
    $newFilename = uniqid() . '.' . $imageFileType; 
    $ruta_a_subir = "../images/" . $newFilename;

    
    if (getimagesize($_FILES["foto"]["tmp_name"]) !== false) {
        
        if ($_FILES["foto"]["size"] < 500000 && in_array($imageFileType, array('jpg', 'png', 'jpeg', 'gif'))) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta_a_subir)) {
                
                $stmt->bindParam(':foto', $newFilename);

                
                if ($stmt->execute()) {
                    $message = 'Usuario creado con exito';
                    header("Location: ../vistas/signup.php");
                    exit;
                } else {
                    $_SESSION['message'] = 'Hubo un error intentando crear el usuario';
                    $_SESSION['message_type'] = "danger";
                    header("Location: ../vistas/signup.php");
                    exit;
                }
            } else {
                $_SESSION['message'] = 'Hubo un error cargando la imagen';
                $_SESSION['message_type'] = "danger";
                header("Location: ../vistas/signup.php");
                exit;
            }
        } else {
            $_SESSION['message'] = 'Tu imageen es muy grande.';
            $_SESSION['message_type'] = "danger";
            header("Location: ../vistas/signup.php");
            exit;
        }
    } else {
        $_SESSION['message'] = 'El archivo no es una imagen.';
        $_SESSION['message_type'] = "danger";
        header("Location: ../vistas/signup.php");
        exit;
    }
} else {
    $_SESSION['message'] = 'Por favor rellena todos los campos y elije una imagen.';
    $_SESSION['message_type'] = "danger";
    header("Location: ../vistas/signup.php");
    exit;
}


