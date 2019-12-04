<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php
  require_once '../css/boot.php';
  require_once '../config/database.php';

    $user_check_query = "SELECT * FROM users WHERE  id={$_COOKIE['user']} LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);


     ?>
    <body>
      <nav class="navbar navbar-expand-md bg-dark navbar-dark ">
    <!-- Brand -->
    <a class="navbar-brand" href="#"><img src ="../images/Logo_file.png" alt="Logo" style="width:70px;" class="mr-2">The Accountant</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto" >
        <li class="nav-item">
          <a class="nav-link" href="adminpage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="chart-of-accounts.php">Chart of Accounts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="usertable.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Journal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Ledger</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Reports</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto" >
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="../images/user.png" alt="user image" style="width:50px;" class=" ml-2 mt-3">
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="class="dropdown-item href="../logout.php">Logout</a>
          </div>
          <p class="text-white"><?=$user['username'] ?></p>
        </li>
      </ul>

    </div>
  </nav>
    </body>
  </html>
