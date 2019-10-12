<p>Profile</p>


<p>User ID: 
    <?php
        if (!$data['id']) {
            echo "Undefined";
        } else {
            echo $data['id'];
        }
    ?>
</p>

<p>Name: <?= $data['name'] ?></p>