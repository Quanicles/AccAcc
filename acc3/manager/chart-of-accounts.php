<?php
require_once "../config/core.php";
require_once "../config/database.php";
require_once '../css/boot.php';
require_once 'mannav.php';

$updated = true;

$sql = "SELECT * FROM chart_acoount";
$result = $conn->query($sql);



$conn->close();


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>The Accountant</title>


</head>
<body>




<!--Displays Chart of Accounts> -->
  <div class="container-fluid">
    <div class="row mt-2">
      <h2 class="text-primary">Chart of Accounts</h2>
      <div class="col">
      <button type="submit" class ="btn-primary rounded mt-2" id="btnCreate">Add</button>
      </div>
      <div class="col mt-2">
        <div class="w-50 input-group mb-3 float-right">
          <input type="text" class="form-control" placeholder="Search">
          <div class="input-group-append-sm">
            <button class="btn  btn-primary" type="button">Search</button>
          </div>
        </div>
      </div>
    <hr>
    </div>


	<table class="tbl-qa table table-hover">
		<thead>
			 <tr>
				<th class="table-header" scope="col">Account Number</th>
				<th class="table-header" scope="col"> Name </th>
				<th class="table-header" scope="col"> Type </th>
        <th class="table-header" scope="col"> Sub-type </th>
        <th class="table-header" scope="col"> Balance </th>
        <th class="table-header" scope="col"> Created By </th>
        <th class="table-header" scope="col"> Creation Date </th>
        <th class="table-header" scope="col"> Comments </th>
			  </tr>
		</thead>
		<tbody>
			<?php

				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
			?>
			<tr class="table-row" scope="row" id="row-<?php echo $row["id"]; ?>">
				<td class="table-row"><a href="#"><?php echo $row["account_number"]; ?></a></td>
				<td class="table-row"><?php echo $row["account_name"]; ?></td>
				<td class="table-row"><?php echo $row["type"]; ?></td>
        <td class="table-row"><?php echo $row["term"]; ?></td>
        <td class="table-row"><?php echo '$'. $row["balance"]; ?></td>
        <td class="table-row"><?php echo $row["created_by"]; ?></td>
        <td class="table-row"><?php echo $row["created_at"]; ?></td>
        <td class="table-row"><?php echo $row["comments"]; ?></td>
				<!-- action -->

			</tr>
			<?php
					}
				}
        if ($result->num_rows == 0) {
          ?>
          <tr class="table-row" scope="row" id="row-<?php echo $row["id"]; ?>">
          <td class="table-row">  no data </td>;
          <?php
        }
			?>
		</tbody>
	</table>
  </div>

  <!-- <a href="edit.php?id=<?php echo $row["id"]; ?>" class="link"><img title="Edit" src="icon/edit.png"/></a> <a href="delete.php?id=<?php echo $row["id"]; ?>" class="link"><img name="delete" id="delete" title="Delete" onclick="return confirm('Are you sure you want to delete?')" src="icon/delete.png"/></a></td> -->



</body>
</html>
