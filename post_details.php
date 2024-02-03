<?php
session_start();
include("db_connection.php");

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

$postId = $_GET['id'] ?? null;

if ($postId) {
    $query = $conn->prepare("SELECT posts.*, usuarios.nombre as autorNombre, usuarios.foto as autorFoto FROM posts JOIN usuarios ON posts.user_id = usuarios.id WHERE posts.id = :id");
$query->bindParam(':id', $postId);
$query->execute();
$post = $query->fetch(PDO::FETCH_ASSOC);

    $query->bindParam(':id', $postId);
    $query->execute();
    $post = $query->fetch(PDO::FETCH_ASSOC);
} else {
    echo "No se especificó un ID de post.";
    exit;
}


include('includes/header.php');
?>

<!-- Mostrar el contenido del post -->
<?php if ($post) : ?>
    <div class="container mt-5">
        <?php if ($post['autorFoto']): ?>
            <img src="images/<?= htmlspecialchars($post['autorFoto']) ?>" alt="Foto del autor" width="100px"/>
        <?php endif; ?>
        <p>Publicado por: <?= htmlspecialchars($post['autorNombre']) ?></p>
        <?php $content = preg_replace("/(\r\n|\r|\n){2,}/", "\n\n", $post['content']);
        
        $content = preg_replace('/(<br\s*\/?>\s*){2,}/', '<br /><br />', $content);

// Imprime el contenido
echo $content; ?>
    </div>
<?php else : ?>
    <p>Post no encontrado.</p>
<?php endif; ?>

<?php include('includes/footer.php'); ?>