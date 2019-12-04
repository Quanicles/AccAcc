<?php
// include classes
require_once "config/core.php";
require_once 'config/database.php';

if (isset($_COOKIE['user'])) {
    $user_check_query = "SELECT role FROM users WHERE  id={$_COOKIE['user']} LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    switch ($user['role']) {
        case 0:
            header('location: adminpage.php');
            break;
        case 1:
            header('location: managerpage.php');
            break;
        case 2:
            header('location: customerpage.php');
            break;
    }
}

if (isset($_POST['create'])) {
  $firstname =  $_POST['firstname'];
  $lastname =  $_POST['lastname'];
  $email =  $_POST['email'];
  $dob =  $_POST['dob'];
  $password =  $_POST['password'];
  // receive all input values from the form
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $dob = mysqli_real_escape_string($conn, $_POST['dob']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  if (!empty($firstname) and !empty($lastname)) {
      $username = $firstname[0] . $lastname ."1911";
  }

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "First name is required"); }
  if (empty($lastname)) { array_push($errors, "Last name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($dob)) { array_push($errors, "Date of birth is required"); }
  if (empty($password)) { array_push($errors, "Password is required"); }




  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE  email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (isset($errors) and count($errors) == 0) {
   $password = md5($password);//encrypt the password before saving in the database

      $query = "INSERT INTO users (firstname, lastname, email, dob, password, username)
         VALUES('$firstname','$lastname', '$email','$dob', '$password','$username')";
   mysqli_query($conn, $query);
   $_SESSION['email'] = $email;
   $_SESSION['success'] = "You are now logged in";
   if (isset($_POST['admin'])) {
       header('location: adminpage.php');
   }
   else {
       header('location: index.php?new=created');

   }

  }
  elseif (isset($_POST['admin'])) {
      header('location: adminpage.php');
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


  <div>
  </div>
  <h1 class="text-center mb-4">The Accountant</h1>
  <div class="row justify-content-around">
    <img src="images/Logo_file.png" class="img-fluid logo ml-3" alt="Project Logo">

    <div class="col-sm-6">
        <h2><?php if (isset($_GET['new'])) print('Registration success. Now administrator needs to approved your account. Then you can log in');?></h2>
      <div class="card mt-5">
        <div class="card-heading bg-primary text-white rounded pt-1 pb-1">
          <h3 class="text-center">Register</h3>
        </div>
        <div class="card-body">
          <form method="post" action="index.php">
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
<!--              <input type="password" class="form-control"  name="password" placeholder="Password" pattern="[a-zA-Z][a-zA-Z0-9\W]{7,}">-->
              <input type="password" class="form-control"  name="password" placeholder="Password" pattern="[a-zA-Z](?=.*\d)(?=.*[a-zA-Z])(?=.*\W).{7,}">
            </div>
            <button type="submit" name="create" class="btn btn-primary">Register</button>
            <p class ="pt-2"><a href ="login.php"> Already a member? Click here to login</a></p>
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
