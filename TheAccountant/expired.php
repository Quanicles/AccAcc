<?php
require_once "config/core.php";
require_once "config/database.php";


if (isset($_COOKIE['user'])) {
    $user_check_query = "SELECT * FROM users WHERE  id={$_COOKIE['user']} LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user['role'] != 0) {
        array_push($errors, "You don't have permission for this page");
    }
    if (isset($errors) and count($errors) == 0) {
        $users_query = "SELECT * FROM users";
        $result = mysqli_query($conn, $users_query);
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        ?>
        <!DOCTYPE html>
        <html lang="en" dir="ltr">
        <head>
            <meta charset="utf-8">
            <title>The Accountant </title>
            <!--            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
            <link rel="stylesheet" href="css/main.css">
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/mdb.css">
        </head>
    <body>
        <!--Navbar -->
        <nav class="mb-1 navbar navbar-expand-lg navbar-dark secondary-color lighten-1">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
                    aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="adminpage.php">Back to admin page</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto nav-flex-icons">
                    <li class="nav-item">
                        <p>Hi, <?=$user['username'] ?>!</p>
                    </li>
                    <li class="nav-item avatar dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-6.jpg" class="rounded-circle z-depth-0"
                                 alt="avatar image">
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary"
                             aria-labelledby="navbarDropdownMenuLink-55">
                            <a href="#" id="logout">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!--/.Navbar -->
    <div class="row row1">
        <div class="col-12">
            <div class="table">
                <h2>Users with expired passwords</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Expired date</th>
                    </tr>
                    <?php foreach ($users as $user): ?>
                        <?php
                        $pwd_expired = date('Y-m-d', strtotime($user['pasword_create'] . $expired));
                        $today = date('Y-m-d', strtotime('now'));
                        if ($today <= $pwd_expired){
                            continue;
                        }
                        ?>
                        <div class="row">
                            <tr>
                                <td><?=$user['firstname'] ?></td>
                                <td><?=$user['lastname'] ?></td>
                                <td><?=$user['email'] ?></td>
                                <td><?=$pwd_expired ?></td>
                            </tr>
                        </div>
                    <?endforeach; ?>
                </table>
            </div>
        </div>

        <?php
    }
}
else {
    array_push($errors, "You are not authorized");
}
require_once "errors.php";
