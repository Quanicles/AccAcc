<?php
require_once "../config/core.php";
require_once "../config/database.php";
require_once '../css/boot.php';
require_once 'adminnav.php';

if (isset($_COOKIE['user'])) {
    $user_check_query = "SELECT * FROM users WHERE  id={$_COOKIE['user']} LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user['role'] != 0) {
        array_push($errors, "You don't have permission for this page");

    }



//        foreach ($users as $user) {
//            var_dump($user);
//            print('<br>');
//        }
//        die();


        ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <script
                src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            <script>
                $( "select[name='changeRole']" ).on('change', function(){
                    elem = this;
                    $.ajax({
                        type: 'POST',
                        url: 'processadmin.php',
                        data: {id: $(this).attr('data-id'), value: this.value, type: 'changeRole'},
                        success: function (data) {
                            var roles = ['Administrator', 'Manager', 'User'];
                            $('#role'+ $(elem).attr('data-id')).html(roles[data]);
                        },
                    });
                });

                $( "select[name='changeStatus']" ).on('change', function(){
                    //alert(this.value);
                    elem = this;
                    $.ajax({
                        type: 'POST',
                        url: 'processadmin.php',
                        data: {id: $(this).attr('data-id'), value: this.value, type: 'changeStatus'},
                        success: function (data) {
                            $('#status'+ $(elem).attr('data-id')).html(data);
                        },
                    });
                });

                $("button[name='vacation']").click(function () {
                    let id = $(this).attr('data-id');
                    let startName = 'start'+id;
                    let endName = 'end'+id;
                    let start = $("input[name=" + startName + "]").attr('value');
                    let end = $("input[name=" + endName + "]").attr('value');
                    $.ajax({
                        type: 'POST',
                        url: 'processadmin.php',
                        data: {id: id, start: start, end: end},
                        success: function (data) {
                           alert(data);
                        },
                    });
                });

                $("#logout").click(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'processadmin.php',
                        data: {logout: true},
                        success: function (data) {
                            window.location.href = 'index.php';
                        },
                    });
                });

                $("#btnCreate").click(function () {
                    $("#user-create").show();
                    $("#btnCreate").hide();
                });

                $("#btnSend").click(function () {
                    $("#mail-create").show();
                    $("#btnSend").hide();
                });
            </script>
        </body>
            </html>
            <?php
  
    }
    else {
        array_push($errors, "You are not authorized");
    }
    require_once "errors.php";
