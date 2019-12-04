<?php
require_once "config/database.php";
require_once "css/boot.php";

$query = "SELECT * FROM chart_acoount";
$result = $conn->query($query);

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>The Accountant</title>
  </head>
  <body>
    <h2 class="text-primary">Ledger</h2>
    <div class="row">
        <label for="startdate" class="ml-4">Start Date:</label>
        <input type="date" class="mr-4" name="startdate">
        <label for="enddate">End Date:</label>
        <input type="date" class="mr-4" name="enddate">
        <input type="text" id="search" class="form-control" placeholder="search" style="width:280px;">
    </div>
    <?php

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
    <div class="row mt-3 mb-2">
      <div class="col-sm-8">
        <h4 class="ml-3 ">Account Name:<?php echo $row["account_name"]; ?></h4>
      </div>
      <div class="col">
         <h4>Account Number:<?php echo $row["account_number"]; ?></h4>
      </div>

    </div>
  <?php }
} ?>
        <?php
        if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = $conn->prepare("SELECT * FROM chart_acoount WHERE id=?");
        $sql->bind_param("i",$_GET["id"]);
        $sql->execute();

         ?>
         <table class="tbl-qa table table-hover" >
       		<thead>
       			 <tr>
       				<th class="table-header" scope="col">PR</th>
       				<th class="table-header" scope="col"> Date </th>
       				<th class="table-header" scope="col"> Description </th>
               <th class="table-header" scope="col"> Debit </th>
               <th class="table-header" scope="col"> Credits </th>
               <th class="table-header" scope="col"> Created By </th>
             </thead>

  <?php
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
}
}
}?>
  </body>
</html>
