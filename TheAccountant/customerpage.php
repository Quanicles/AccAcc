<?php
require_once "config/core.php";
require_once "config/database.php";

if (isset($_COOKIE['user'])) {
    $user_check_query = "SELECT * FROM users WHERE  id={$_COOKIE['user']} LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user['role'] != 2) {
        array_push($errors, "You don't have right access level for the page");
    }
    else {
      require_once 'nav.php';
        ?>
        <!DOCTYPE html>
        <html lang="en" dir="ltr">
        <head>

        </head>
        <body>
      
        <p>Users page!</p>

    </body>
        </html>
<?php
    }
}
else {
    array_push($errors, "You are not authorized");
}


require_once "errors.php";

?>
