<?php
require_once "config/core.php";
require_once "config/database.php";

//$q = "UPDATE users SET pasword_create = '2019-09-24 00:00:00.00' WHERE id = 29;";
//$result = mysqli_query($conn, $q);
//if (!$result) {
//    die('Bad request: ' . $q);
//}

$user_check_query = "SELECT * FROM users";
$result = mysqli_query($conn, $user_check_query);
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>
<?php foreach ($users as $user): ?>
<pre>
    <?php
    $pwd_create = date('Y-m-d', strtotime($user['pasword_create']));
    $pwd_expired = date('Y-m-d', strtotime($user['pasword_create'] . $expired));

    ?>
    <? print_r($user) ?>
    <?=$pwd_create ?>
    <?=$pwd_expired ?>
</pre>
<?php endforeach; ?>