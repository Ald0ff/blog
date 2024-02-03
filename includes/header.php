<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://kit.fontawesome.com/58b74db373.js" crossorigin="anonymous"></script>
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container text-white">
            <?php if (!empty($user)) : ?>
                <div class="d-flex gap-3 align-items-end">
                    <a href="perfil.php" class="navbar-brand">
                        <img src="<?= "images/", $user['foto']; ?>" style="width: 50px; height: 50px" class=" rounded-circle " alt="">
                    </a>
                    <!-- <h3 class="text-white">
                        <?= $user['nombre']; ?>
                    </h3> -->
                </div>
                <div>
                    <a href="blogs.php" class="header-text navbar-brand">Blog</a>
                    <a href="perfil.php" class="header-text navbar-brand">Perfil</a>
                </div>
            <?php else : ?>
                <h2>Blogs</h2>
            <?php endif; ?>
        </div>
    </nav>