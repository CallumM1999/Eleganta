<p>Profile page </p>

<?php

    if(isset($data['message'])) {
        echo "<p>" . $data['message'] . "</p>";
    } 

?>


<form action="<?= URLROOT ?>/profile" method="post">
    <input type="text" name="user" id="">

    <input type="submit" value="Submit">
</form>