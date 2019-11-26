<?php
// core configuration
require_once "config/core.php";
require_once "config/database.php";

if (isset($_COOKIE['user'])) {
    $user_check_query = "SELECT role FROM users WHERE  id={$_COOKIE['user']} LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    switch ($user['role']) {
        case 0:
            header('location: admin/adminpage.php');
            break;
        case 1:
            header('location: manager/managerpage.php');
            break;
        case 2:
            header('location: customerpage.php');
            break;
    }
}

if (isset($_POST['sing-in'])) {
    $email =  $_POST['email'];
    $password =  $_POST['password'];

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    $user_check_query = "SELECT * FROM users WHERE  email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    $isAdmin = false;
    $isManager = false;

    if (!$user) { // if user not exists
        array_push($errors, "email not exist");
    }
    elseif (md5($password) != $user['password']) {
            array_push($errors, "password not match");
    }
    elseif ($user['status'] == 'pending') {
        array_push($errors, "Account not approved by Admin");
    }
    elseif ($user['status'] == 'blocked') {
        array_push($errors, "Account was blocked");
    }
    elseif (isset($user['start_date'])) {
        $start = date('Y-m-d', strtotime($user['start_date']));
        $end = date('Y-m-d', strtotime($user['end_date']));
        $today = date('Y-m-d', strtotime('now'));
        if (($today >= $start) && ($today <= $end)){
            array_push($errors, "Account on vacation");
        }
    }
    elseif ($user['role'] == 0) {
        $isAdmin = true;
    }
    elseif ($user['role'] == 1) {
        $isManager = true;
    }

    if (isset($errors) and count($errors) == 0) {
        setcookie('user', $user['id'], time()+3600);
        if ($isAdmin) {
            header('location: admin/adminpage.php');
        }
        elseif ($isManager) {
            header('location: manager/managerpage.php');
        }
        else {
            header('location: customerpage.php');
        }
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
    <img src="images/Logo_file.png" class="img-fluid logo ml-3" alt="Project Logo">

    <div class="col-sm-6">
      <div class="card mt-5">
        <div class="card-heading bg-primary text-white rounded pt-1 pb-1">
          <h3 class="text-center">Login</h3>
        </div>
        <div class="card-body">
          <form action="" method="post">
              <?php include('errors.php'); ?>
            <div class="form-group">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control" name ="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name ="password" placeholder="Enter password" required>
            </div>
            <button type="submit" name="sing-in" class="btn btn-primary">Login</button>
            <p class ="pt-2"><a href ="forgotpassword.php"> Forgot Password</a></p>
            <p class ="pt-2"><a href ="index.php"> Not a member? Click here to register</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
