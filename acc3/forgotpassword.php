<?php
if (isset($_POST) and isset($_POST['email'])) {

    // core configuration
    require_once "config/core.php";
    require_once "config/database.php";

    $email =  $_POST['email'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (empty($email)) { array_push($errors, "Email is required"); }

    $user_check_query = "SELECT * FROM users WHERE  email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) { // if user not exists
        array_push($errors, "email not exist");
    }

    if (isset($errors) and count($errors) == 0) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $resetURL = substr(str_shuffle($permitted_chars), 0, 10);

        $user_reset_query = "UPDATE users SET reset = '{$resetURL}' WHERE id = '{$user['id']}'";
        $result = mysqli_query($conn, $user_reset_query);

        if ($result) {
            $to = $user['email'];
            $subject = 'Reset password';
            $message = 'For reset your password go to link <a href="http://thaccountant/resetpassword.php?reset=' . $resetURL . '">http://thaccountant/resetpassword.php?reset=' . $resetURL . '</a>';
            $result = mail($to, $subject, $message);
            if (!$result) {
                array_push($errors, "Reset link was not send");
            }
        }
        else {
            array_push($errors, "Reset link was not add to database");
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
        <?php if(isset($errors) and count($errors) == 0): ?>
            <p>Email with reset link was send to your email!</p>
        <?php else: include "errors.php"; endif;?>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>

    <?php
}
else {
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
            <h1>Reset Password</h1>
            <div class="sc-container">
                <form method="post">
                    <input type="text" placeholder="Email" name="email"/>
                    <input type="submit" value="Get New Password" name="resetPwd"/>
                </form>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
}