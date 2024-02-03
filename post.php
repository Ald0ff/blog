<?php

require 'db_connection.php';


$filterByCurrentUser = $filterByCurrentUser ?? false;

if ($filterByCurrentUser && isset($userId)) {

    $postsQuery = $conn->prepare("SELECT posts.id, posts.content, posts.created_at, usuarios.nombre, usuarios.foto FROM posts JOIN usuarios ON posts.user_id = usuarios.id WHERE posts.user_id = :userId ORDER BY posts.created_at DESC");
    $postsQuery->bindParam(':userId', $userId);
} else {

    $postsQuery = $conn->query("SELECT posts.id, posts.content, posts.created_at, usuarios.nombre, usuarios.foto FROM posts JOIN usuarios ON posts.user_id = usuarios.id ORDER BY posts.created_at DESC");
}

$postsQuery->execute();
$posts = $postsQuery->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if (!$posts) : ?>
    <div class='d-flex  mb-3 align-items-end justify-content-center'>
        <h2>
            Aun no hay posteados
        </h2>
    </div>
<?php endif; ?>
<?php foreach ($posts as $post) : ?>
    <div class="card mb-3 p-3">
        <div class='d-flex gap-3 mb-3 align-items-end'>
            <!-- Asegúrate de que la ruta a las imágenes y el atributo alt estén correctos -->
            <img src="images/<?= $post['foto'] ? htmlspecialchars($post['foto']) : 'default.jpg'; ?>" style="width: 50px; height: 50px" class="rounded-circle" alt="<?= htmlspecialchars($post['nombre']) ?>">
            <h2>
                <?= htmlspecialchars($post['nombre']) ?>
            </h2>
        </div>
        <p>
            <?= date('j M Y', strtotime($post['created_at'])) ?>
        </p>
        <div class="texto-limitado">
            <?php $cleanContent = htmlspecialchars($post['content']);

            $content = preg_replace("/(\r\n|\r|\n){2,}/", "\n\n", $cleanContent);

            echo nl2br($content);
            ?>
        </div>
        <p>
            <a href="post_details.php?id=<?= $post['id']; ?>">leer mas</a>
        </p>
        <?php if ($filterByCurrentUser) : ?>
            <div class="mt-2">
                <a class="btn btn-danger" href="controllers/eliminar_post.php?id=<?php echo $post['id']; ?>">
                    Eliminar
                    <i class="fa-solid fa-trash"></i>
                </a>
                <a data-bs-toggle="modal" data-bs-target="#editar-<?php echo $post['id']; ?>" class="btn btn-primary" href="#">
                    Editar
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
            </div>

            <div class="modal fade" id="editar-<?php echo $post['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content p-3">
                        <form action="controllers/editar_post.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-3 d-flex flex-column">
                                <label class="mb-2" for="content">Nuevo Contenido</label>
                                <textarea class="form-control rounded" rows="4" type="text" id="content" name="content" placeholder="Contenido" autofocus><?= nl2br(htmlspecialchars($post['content'])) ?></textarea>
                            </div>
                            <input type="hidden" name="id" value="<?= $post['id']; ?>">
                            <button name="update" type="submit" class="btn btn-success d-block ms-auto">Actualizar Post</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>