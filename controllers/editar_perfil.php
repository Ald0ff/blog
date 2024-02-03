<?php
include("../db_connection.php");

if (isset($_POST['update'])) {
    $id = $_POST["id"]; 
    $nombre = $_POST["nombre"];
    $foto = null;

    if (!empty($_FILES["foto"]["name"])) {
        $basename = basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
        $newFilename = uniqid() . '.' . $imageFileType;
        $ruta_a_subir = "../images/" . $newFilename;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta_a_subir)) {
            $foto = $newFilename;
        } else {
            echo "Error al cargar el archivo.";
            exit;
        }
    } else {
        
        $query = $conn->prepare("SELECT foto FROM usuarios WHERE id = ?");
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $foto = $result['foto'];
    }

    
    $query = $conn->prepare("UPDATE usuarios SET nombre = ?, foto = ? WHERE id = ?");
    $query->bindParam(1, $nombre, PDO::PARAM_STR);
    $query->bindParam(2, $foto, PDO::PARAM_STR);
    $query->bindParam(3, $id, PDO::PARAM_INT);
    $query->execute();

    header("Location: ../perfil.php");
    exit;
}
?>
