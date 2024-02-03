<div class=" ">

    <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php

        session_unset();
        session_destroy();
    } ?>


    <div class="card card-body login-form">
        <h1>Login</h1>

        <form action="controllers/login.php" method="POST">

            <div class="form-group mb-3">
                <input type="text" name="email" class="form-control" placeholder="Correo" autofocus>
            </div>

            <div class="form-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="contraseña" autofocus>
            </div>

            <input type="submit" name="Ingresar" class="btn btn-success btn-block" value="Ingresar">
        </form>
    </div>
</div>