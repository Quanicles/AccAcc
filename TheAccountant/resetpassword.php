<?php
if (isset($_POST) and isset($_POST['pwd'])) {

    // core configuration
    require_once "config/core.php";
    require_once "config/database.php";


    $reset = mysqli_real_escape_string($conn, $_POST['reset']);
    $password = mysqli_real_escape_string($conn, $_POST['pwd']);
    $password = md5($password);


    $user_check_query = "SELECT * FROM users WHERE  reset='$reset' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        array_push($errors, "User not found");
    }
    else {
        $user_new_query = "UPDATE users SET password = '{$password}' WHERE reset = '$reset';";
        $result = mysqli_query($conn, $user_new_query);
        $delete_reset_query = "UPDATE users SET reset = NULL WHERE id = '{$user['id']};'";
        $result2 = mysqli_query($conn, $user_new_query);
        if ($result and $result2) {
            header( "refresh:3;url=login.php" );
            echo 'Password changed success! Redirecting to login page...';
        }
        else {
            array_push($errors, "Password not changed");
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>The Accountant </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
    <h1 class="text-center mb-4">The Accountant</h1>
    <div class="row justify-content-around">
        <?php include "errors.php"; ?>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php
}

    ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>The Accountant</title>
    <link rel="stylesheet" href="css/reset.css">
</head>
<body>
<div class="card mt-5">
    <div id="sc-password">
        <h1>Create New Password</h1>
        <div class="sc-container">
            <form method="post">
                <input type="hidden" name="reset" value="<?=$_GET['reset'] ?>">
                <input type="password" placeholder="New password" name="pwd"/>
                <input type="submit" value="Get New Password" name="resetPwd"/>
            </form>
        </div>
    </div>
</div>
</body>
</html>
