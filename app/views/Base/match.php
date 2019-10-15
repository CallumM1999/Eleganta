<?php include APPROOT . '/views/inc/header.php'; ?>

<p>Match route works!</p>



<p>Users</p>
<hr>
<ul>
    <?php foreach ($data['users'] as $user): ?>

        <li><?= $user->name ?></li>

    <?php endforeach; ?>
</ul>

<?php include APPROOT . '/views/inc/footer.php'; ?>