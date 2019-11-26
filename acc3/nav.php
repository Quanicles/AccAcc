<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php
  require_once 'css/boot.php';

   ?>
  <body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark ">
  <!-- Brand -->
  <a class="navbar-brand" href="#"><img src ="images/Logo_file.png" alt="Logo" style="width:70px;" class="mr-2">The Accountant</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto" >
      <li class="nav-item">
        <a class="nav-link" href="customerpage.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#chart-of-accounts.php">Chart of Accounts</a>
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
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>

  </div>
</nav>
  </body>
</html>
