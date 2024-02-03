<?php
session_start();

require 'db_connection.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password, nombre, foto FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
        $user = $results;
    }
}
?>

<body class="bg-light">
    <?php
    
    include('includes/header.php')
    ?>
    <div class="container col-md-5 mt-5">
        <articule class="card border-1 p-4 rounded-2">
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
            <form class="mb-0" action="controllers/agregar_post.php" method="POST" enctype="multipart/form-data">
                <div class='d-flex gap-3 mb-3'>
                    <img src="images/<?= $user['foto']; ?>" style="width: 50px; height: 50px" class="rounded-circle" alt="User Image">
                    <input data-bs-toggle="modal" data-bs-target="#publicar" type="text" name="content" class="rounded-5 p-2 w-100" placeholder="Crear publicación">
                </div>
                <input type="hidden" name="id" value="<?= $user['id']; ?>">
                <div>
                </div>
            </form>
            <div class="modal fade" id="publicar" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content p-3">
                        <form action="controllers/agregar_post.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-3 d-flex flex-column">
                                <label class="mb-2" for="content">Nueva publicacion</label>
                                <textarea type="text"  class="form-control rounded" rows="4" autofocus id="content" name="content" placeholder="Crear publicacion"></textarea>
                            </div>
                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                            <button name="update" type="submit" class="btn btn-success btn-block d-block ms-auto">Publicar</button>
                        </form>
                    </div>
                </div>
            </div>
        </articule>
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