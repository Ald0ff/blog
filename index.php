<?php 

include('includes/header.php');
session_start();
?>

<div class="container p-4 d-flex justify-content-center">
    <div class="col-md-5 mb-4">
        <?php
        include('login.php');
        ?>

        <div class="mt-5">
            <a href="signup.php" class="btn btn-primary btn-block signup">
                Signup
            </a>
        </div>
    </div>
</div>
<script src="./scripts/login.js"></script>
<?php
include('includes/footer.php');
?>