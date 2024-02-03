<?php
session_start(); //

require 'db_connection.php';

$filterByCurrentUser = true;


if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}


$userId = $_SESSION['user_id'];
try {
    $records = $conn->prepare('SELECT id, email, password, nombre, foto FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $userId);
    $records->execute();
    $user = $records->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Usuario no encontrado.");
    }

    $postsQuery = $conn->prepare("SELECT id, content, created_at FROM posts WHERE user_id = :userId ORDER BY created_at DESC");
    $postsQuery->bindParam(':userId', $userId);
    $postsQuery->execute();
    $posts = $postsQuery->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<?php

include('includes/header.php')
?>

<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['message_type']) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
    ?>
<?php } ?>
<div class="container col-md-5">
    <section class="card  mb-5 mt-3 p-3 rounded-2">
        <div class="d-flex position-relative flex-column align-items-center gap-3 border-1 align-items-end ">
            <img src="<?= "images/", $user['foto']; ?>" style="width: 150px; height: 150px" class=" rounded-circle " alt="">
            <div class="d-flex gap-5">
                <h1>
                    <?= $user['nombre']; ?>
                </h1>
            </div>
            <a href="controllers/logout.php" class="btn btn-danger btn-block">
                Logout
            </a>
            <button data-bs-toggle="modal" data-bs-target="#miModal" style="height: 55px; width: 55px" class="ms-auto position-absolute top-5 end-0 btn rounded-circle bg-light p-2" type="button">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
        </div>
    </section>
    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <form action="controllers/editar_perfil.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3 d-flex flex-column">
                        <label class="mb-2" for="">Nuevo Nombre </label>
                        <input class="form-control" type="text" name="nombre" value="<?= $user['nombre']; ?>" placeholder="Nombre">
                    </div>
                    <div class="form-group mb-3">
                        <label class="mb-2" for="">Nueva foto de perfil </label>
                        <input type="file" name="foto" class="form-control" placeholder="Foto de perfil" autofocus>
                    </div>
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                    <button name="update" type="submit" class="btn btn-success d-block ms-auto">Actualizar Perfil</button>
                </form>
            </div>
        </div>
    </div>
    <hr>

    <section>
        <?php
        include('post.php');
        ?>
    </section>

</div>
<?php
include('includes/footer.php');
?>