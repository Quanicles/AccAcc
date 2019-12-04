<?php
require_once "../config/core.php";
require_once "../config/database.php";


if (isset($_COOKIE['user'])) {
    $user_check_query = "SELECT * FROM users WHERE  id={$_COOKIE['user']} LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user['role'] != 1) {
        array_push($errors, "You don't have right access level for the page");
    }
    else {
      require_once 'mannav.php';
        ?>
        <!DOCTYPE html>
        <html lang="en" dir="ltr">
          <head>
            <meta charset="utf-8">
            <title></title>
          </head>
          <body>
            <p>Manager page!</p>

                </body>
                    </html>
                    <?php

            }
          }
            else {
                array_push($errors, "You are not authorized");
            }
            require_once "../errors.php";
