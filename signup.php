
<?php

session_start();
include('includes/header.php');
?>


<div class="container p-4 ">
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
unset($_SESSION['message']);
unset($_SESSION['message_type']);
} ?>
    <div class="col-md-5 mb-4">
        <div class="card card-body signup-form" id="signup-form">
            <h1>Signup</h1>

            <form action="controllers/signup.php" method="POST" enctype="multipart/form-data">

                <div class="form-group mb-3">
                    <input name="email" type="text" class="form-control" placeholder="Enter your email" autofocus>
                </div>

                <div class="form-group mb-3">
                    <input name="nombre" type="text" class="form-control" placeholder="Enter your user name" autofocus>
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="contraseña" autofocus>
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="confirm_password" class="form-control" placeholder="confirmar contraseña" autofocus>
                </div>

                <div class="form-group mb-3">
                    <input type="file" name="foto" class="form-control" placeholder="Foto de perfil" autofocus>
                </div>

                <input type="submit" name="Ingresar" class="btn btn-success btn-block" value="Registrarse">
            </form>
        </div>
        <div class="mt-5">
            <a href="../index.php" class="btn btn-primary btn-block signup">

                Login
            </a>
        </div>

    </div>
</div>
<script src="scripts/login.js"></script>
<?php
include('includes/footer.php');
?>