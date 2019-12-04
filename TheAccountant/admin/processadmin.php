<?php
if (isset($_POST)) {
    require_once "../config/core.php";
    require_once "../config/database.php";

    if (isset($_POST['type']) and $_POST['type'] == 'changeRole') {
        $user_update_query = "UPDATE users SET role={$_POST['value']} WHERE id={$_POST['id']}";
        $result = mysqli_query($conn, $user_update_query);
        if ($result) {
            $user_update_query = "SELECT role FROM users WHERE id = {$_POST['id']}";
            $result = mysqli_query($conn, $user_update_query);
            $role = mysqli_fetch_assoc($result);
            echo $role['role'];
        }
        else {
            echo 'error';
        }
    }
    elseif (isset($_POST['type']) and $_POST['type'] == 'changeStatus') {
        $user_update_query = "UPDATE users SET status='{$_POST['value']}' WHERE id={$_POST['id']}";
        $result = mysqli_query($conn, $user_update_query);
        if ($result) {
            $user_update_query = "SELECT status FROM users WHERE id = {$_POST['id']}";
            $result = mysqli_query($conn, $user_update_query);
            $role = mysqli_fetch_assoc($result);
            echo $role['status'];
        }
        else {
            echo 'error1';
        }
    }
    elseif(isset($_POST['logout'])) {
        unset($_COOKIE['user']);
        setcookie('user', null, -1, '/');
    }
    elseif(isset($_POST['start'])) {
        $user_update_query = "UPDATE users SET start_date='{$_POST['start']}', end_date='{$_POST['end']}' WHERE id={$_POST['id']}";
        $result = mysqli_query($conn, $user_update_query);
        if ($result) {
            header('location: usertable.php');
        }
        else {
            echo 'Database error!';
        }
    }
    elseif ($_POST['sendMail']) {
        $to = $_POST['userEmail'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $result = mail($to, $subject, $message);
        if (!$result) {
            echo "Mail to user was not send";
        }
        else {
            header( "refresh:2;url=usertable.php" );
            echo 'Mail send success! Redirecting to user table page...';
        }
    }
    else {
        echo 'Error!';
    }
}
