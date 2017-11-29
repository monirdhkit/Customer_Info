<form class="col-12 col-sm-12 col-md-10 col-lg-8 mt-2 offset-md-2" method="post" action="settings.php">
    <input type="text" name="admin_new_password" class="form-control mb-2 mr-sm-2 mb-sm-0 mt-2" placeholder="New Password">
    <input type="password" name="verify_password" class="form-control mb-2 mr-sm-2 mb-sm-0 mt-2" placeholder="Old Password">
    <input type="hidden" name="admin_id" class="form-control mb-2 mr-sm-2 mb-sm-0 mt-2" value="<?php echo $row['user_id']?>">

    <?php if(isset($_GET['status']) && $_GET['status']=="incorrect") : ?>
        <div class="alert alert-success mt-2" role="alert">Incorrect Admin Password</div>
    <?php elseif(isset($_GET['status']) && $_GET['status']=="success"):?>
        <div class="alert alert-success mt-2" role="alert">Successfully Changed</div>
    <?php endif; ?>

    <div class="text-center">
        <button type="submit" value="Change" name="change" class="btn btn-primary mt-2">Change</button>
    </div>
</form>