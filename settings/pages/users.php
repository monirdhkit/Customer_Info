<?php

include 'db.php';

$stmt = $db->prepare("SELECT user_id,user_name,user_email FROM users WHERE user_type=:user_type");
$stmt->bindValue(':user_type', 'user');
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<a href="create_user.php" role="button" class="btn btn-primary mt-2">New User</a>

<?php if(isset($_GET['status']) && $_GET['status']=="success") : ?>
    <div class="alert alert-success mt-2" role="alert">Successfully Deleted</div>
<?php endif; ?>

<table class="table mt-2">
    <thead class="thead-light">
    <tr>
        <th scope="col">User Name</th>
        <th scope="col">User E-mail</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($rows as $row): ?>
    <tr>
        <td><?php echo $row['user_name'] ?></td>
        <td><?php echo $row['user_email'] ?></td>
        <td><a href="../settings.php?id=<?php echo $row['user_id'] ?>" role="button" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>