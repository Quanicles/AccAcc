<?php
require_once "../config/core.php";
require_once "../config/database.php";
require_once '../css/boot.php';
require_once 'adminnav.php';


if (isset($errors) and count($errors) == 0) {
    //create tables with users
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
    <title></title>
  </head>
  <body>
<!-- all users in the database -->
    <div class="container-fluid">

      </div>
        <div class="row  mt-3 ">
          <div class="col">
            <h2 class="text-primary">Users</h2>
          </div>
          <div class="btn-group btn-group-sm">
  <button class="btn btn-primary mr-2 rounded" id="btnCreate">Create user</button>
  <button class="btn btn-success rounded" id="btnSend">Send Email</button>
</div>
        </div>
        <!--Add user-->
        <div id = "user-create" class="col-6 border " style="display: none;">
            <h3 class="text-primary text-center">Create user</h3>
            <form method="post" action="action.php">
                <input type="hidden" name="admin" value="1">
                <?php include('errors.php'); ?>
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" >
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" >
                </div>
                <div class="form-group">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" class="form-control" name="dob" >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control"  name="password" placeholder="Password" >
                </div>
                <button type="submit" name="create" class="btn btn-primary mb-2">Register user</button>
            </form>
        </div>
        <!--Send email-->
        <div id = "mail-create" class="col-6 border" style="display: none;">
            <h3 class="text-primary text-center">Send mail</h3>
            <form method="post" action="../processadmin.php">
                <input type="hidden" name="admin" value="1">
                <?php include('errors.php'); ?>
                <div class="form-group">
                    <label for="firstname">Choose user</label>
                    <select name="userEmail" id="userEmail">
                        <?php foreach ($users as $user): ?>
                            <option value="<?=$user['email'] ?>"><?=$user['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" name="subject" id="subject">
                </div>
                <div class="form-group">
                    <label for="message">Message</label><br>
                    <textarea name="message" id="message" cols="50" rows="8" placeholder="Write message body here"></textarea>
                </div>
                <button type="submit" name="sendMail" value="send" class="btn btn-primary mb-2">Send mail</button>
            </form>
        </div>

        <!-- Display Users in the system-->
        <table class="table table-hover mt-2">
          <thead>
            <tr>
                <th class="table-header" scope="col">Name</th>
                <th class="table-header" scope="col">Surname</th>
                <th class="table-header" scope="col">Email</th>
                <th class="table-header" scope="col">Date Of Birth</th>
                <th class="table-header" scope="col">Role</th>
                <th class="table-header" scope="col">Set Role</th>
                <th class="table-header" scope="col">Status</th>
                <th class="table-header" scope="col">Set Status</th>
                <th class="table-header" scope="col">Start Date</th>
                <th class="table-header" scope="col">End Date</th>
                <th class="table-header" scope="col">Send On Vacation</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($users as $user): ?>
            <div class="row">
                <tr>
                    <td><?=$user['firstname'] ?></td>
                    <td><?=$user['lastname'] ?></td>
                    <td><?=$user['email'] ?></td>
                    <td><?=$user['dob'] ?></td>
                    <td id="role<?=$user['id'] ?>"><?php
                        switch ($user['role']) {
                            case 0:
                                echo 'Administrator';
                                break;
                            case 1:
                                echo 'Manager';
                                break;
                            case 2:
                                echo 'User';
                                break;
                        }
                        ?></td>
                    <td><select name="changeRole" data-id="<?=$user['id'] ?>">
                            <option value="0">Administrator</option>
                            <option value="1">Manager</option>
                            <option value="2">User</option>
                        </select>
<!--                                    <input type="hidden" name="id" value="--><?//=$user['id'] ?><!--">-->
                    </td>
                    <td id="status<?=$user['id'] ?>"><?=$user['status'] ?></td>
                    <td><select name="changeStatus" data-id="<?=$user['id'] ?>">
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="blocked">Blocked</option>
                        </select>
                    </td>
                    <form action="../processadmin.php" method="post" name="date<?=$user['id'] ?>">
                        <input type="hidden" name="id" value="<?=$user['id'] ?>">
                        <td>
                            <input type="date" name="start" min="now" value="<? if (isset($user['start_date'])) echo date('Y-m-d', strtotime($user['start_date'])); else{ echo ''; } ?>">
                        </td>
                        <td>
                            <input type="date" name="end" min="now" value="<? if (isset($user['end_date'])) echo date('Y-m-d', strtotime($user['end_date'])); else{ echo ''; } ?>">
                        </td>
                        <td>
<!--                                        <button name="vacation" data-id="--><?//=$user['id'] ?><!--">Send</button>-->
                            <input type="submit" name="submit" value="Send">
                        </td>
                    </form>
                </tr>
                <?php endforeach; ?>
          </tbody>
        </div>
        </table>
        </div>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
        <script>
            $( "select[name='changeRole']" ).on('change', function(){
                elem = this;
                $.ajax({
                    type: 'POST',
                    url: '../processadmin.php',
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
                    url: '../processadmin.php',
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
                    url: '../processadmin.php',
                    data: {id: id, start: start, end: end},
                    success: function (data) {
                       alert(data);
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
