<?php $currentPage = "Passowrd Recovery"; ?>
<?php require_once("includes/header.php"); ?>

    <div class="container">
        <div class="content">
            <h2 class="heading">Password Recovery</h2>
            <div class='notification'>You need to wait at lest 20 minutes for another request</div>
            <form action="" method="POST">
                <div class="input-box">
                    <input type="text" class="input-control" placeholder="Username" name="user-name" required>
                </div>
                <div class="input-box">
                    <input type="email" class="input-control" placeholder="Email address" name="user-email" required>
                </div>
                <div class="input-box">
                    <input type="submit" class="input-submit" value="RECOVER PASSWORD" name="password-recovery" required>
                </div>
            </form>
        </div>
    </div>

<?php require_once("includes/footer.php"); ?>