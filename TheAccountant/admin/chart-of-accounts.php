<?php
require_once "../config/core.php";
require_once "../config/database.php";
require_once '../css/boot.php';
require_once 'adminnav.php';
include 'action.php';

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
  <?php
    if(isset($_SESSION['response'])){

   ?>

   <div class="alert alert-success alert-<?= $_SESSION['res_type']; ?> alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?= $_SESSION['response']; ?>
</div>
<?php } unset($_SESSION['response']); ?>

    <div id = "account-create"  style="display: none;">
      <div class="card mx-auto mt-3 collapse" style="width:500px" >
        <div class="card-header text-center bg-primary text-white">
          <h4>Add Account</h4>
        </div>
        <div class="card-body">
          <form action="action.php" method="post" type="hidden">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <table cellspacing="0" cellpadding="0">
              <tr>
                <th>Account Number</th>
                <td><input type="text" class="ml-3 mt-2" name="account_number" placeholder="Account Number" value="<?php echo $account_number; ?>"/></td>
              </tr>
              <tr>
                <th>Account Name</th>
                <td><input type="text" class="ml-3" name="account_name" placeholder="Account Name" value="<?php echo $account_name; ?>"/></td>
              </tr>
              <tr>
                <th>Type</th>
                <td>
                  <select class="ml-3" name="type" value="Account Type">
                    <option value="Assets <?php echo $type; ?>">Assets</option>
                    <option value="Liabilities <?php echo $type; ?>">Liabilities</option>
                    <option value="Owners_equity <?php echo $type; ?>">Owner's Equity</option>
                    <option value="Revenue <?php echo $type; ?>">Revenues</option>
                    <option value="Operating_expenses <?php echo $type; ?>">Operating Expenses</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Term</th>
                <td><input type="text" class="ml-3" name="term" placeholder="Term" value="<?php echo $term ?>" /></td>
              </tr>
              <tr>
                <th>Balance</th>
                <td><input type="text" class="ml-3" name="balance" placeholder="Balance" value="<?php echo $balance ?>"/></td>
              </tr>
              <tr>
                <th>Comments</th>
                <td><input type="text" class="ml-3" name="comments" placeholder="Comments" value="<?php echo $comments ?>"/></td>
              </tr>
              <tr>
                  <td>
                    <div class="justify-content-end">
                      <button type="submit" name ="add" class="btn-primary mt-3 mr-2 ">Save</button>
                    <a href="chart-of-accounts.php"><button name ="cancel" type="button mt-3" class="btn-warning">Cancel</button></a></td>
                    </div>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>



<!--Displays Chart of Accounts> -->
  <div class="container-fluid">
    <div class="row mt-2">
      <h2 class="text-primary">Chart of Accounts</h2>
      <div class="col">
      <button type="submit" class ="btn-primary rounded mt-2" id="btnCreate">Add</button>
      </div>
      <div class="col mt-2">
        <div class="w-50 input-group mb-3 float-right">
            <input type="text" id="search" class="form-control" placeholder="search" >
            <div class="input-group-append-sm">
              <button class="btn  btn-primary"  type="button">Search</button>
          </div>
        </div>
      </div>
    <hr>
    </div>


	<table class="tbl-qa table table-hover" >
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
				<th class="table-header" scope="col" colspan="2">Action</th>
			  </tr>
		</thead>
		<tbody id="accTable">
			<?php

				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
			?>
			<tr class="table-row" scope="row" id="row-<?php echo $row["id"]; ?>">
				<td class="table-row"><a href="../iledger.php?id=<?= $row["id"]; ?>"><?php echo $row["account_number"]; ?></a></td>
				<td class="table-row"><?php echo $row["account_name"]; ?></td>
				<td class="table-row"><?php echo $row["type"]; ?></td>
        <td class="table-row"><?php echo $row["term"]; ?></td>
        <td class="table-row"><?php echo '$'. number_format($row["balance"],2); ?></td>
        <td class="table-row"><?php echo $row["created_by"]; ?></td>
        <td class="table-row"><?php echo date('Y-m-d', strtotime($row["created_at"])); ?></td>
        <td class="table-row"><?php echo $row["comments"]; ?></td>
				<!-- action -->
				<td class="table-row" colspan="2">
          <a href="chart-of-accounts.php?edit=<?= $row["id"]; ?>"; class="badge badge-primary p-2">Edit</a>
          <a href="chart-of-accounts.php?delete=<?= $row['id']; ?>" class="badge badge-danger p-2 ml-2" onclick="return confirm('Do you want to delete this account?')" >Delete</a>
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


  <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
  $("#btnCreate").click(function () {
      $("#account-create").show();
      $("#btnSend").hide();
  });
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#accTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});</script>
</body>
</html>
