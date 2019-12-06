<?php
session_start();
require_once "../config/database.php";
// Add a account
if(isset($_POST['add'])){
  $account_number = $_POST['account_number'];
  $account_name = $_POST['account_name'];
  $type = $_POST['type'];
  $term = $_POST['term'];
  $balance = $_POST['balance'];
  $comments=$_POST['comments'];
  $sql = "SELECT * FROM chart_acoount WHERE account_number = '$account_number' OR  account_name = '$account_name'";
  if ($result=mysqli_query($conn,$sql))
  {
    // Check no of rows
    if(mysqli_num_rows($result))
    {
      $_SESSION['response'] = "Account in use";
      mysqli_close($conn);
      header('location:chart-of-accounts.php');
      exit();

    }
    else if(!is_numeric($account_number)){
      $_SESSION['response'] = "Account number contains non-numeric values";
      mysqli_close($conn);

      header('location:chart-of-accounts.php');
      exit();
    }
    else{
    $query = "INSERT INTO chart_acoount (account_number, account_name, type, term, balance, comments) VALUES (?,?,?,?,?,?)";
    $stmt =$conn->prepare($query);
    $stmt->bind_param("isssis",$account_number,$account_name,$type,$term,$balance,$comments);
    $stmt->execute();
  }
  header('location:chart-of-accounts.php');
  $_SESSION['response'] = "Successfully Inserted into the database";
  $_SESSION['res_type'] ="Success";
  }




}

//delete a account if balance =0
if(isset($_GET['delete'])){
  $id =$_GET['delete'];
  $query="DELETE FROM chart_acoount WHERE id=? AND balance =0";
  $stmt=$conn->prepare($query);
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $_SESSION['response'] = "Successfully Deleted from the database";
  $_SESSION['res_type'] ="Danger";
  header('location:chart-of-accounts.php');

}


//edit accounts
if(isset($_GET['edit'])){
  $id = $_GET['edit'];

  $sql = $conn->prepare("SELECT * FROM chart_acoount WHERE id=?");
	$sql->bind_param("i",$_GET["id"]);
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
	}

  $id=$row['id'];
  $account_number=row['account_number'];
  $account_name=row['account_name'];
  $type=row['type'];
  $term=row['term'];
  $balance= row['balance'];
  $comments=row['comments'];
  $updated = true;
}


// admin add a user
if(isset($_POST['create'])){
  $firstname =  $_POST['firstname'];
  $lastname =  $_POST['lastname'];
  $email =  $_POST['email'];
  $dob =  $_POST['dob'];
  $password =  $_POST['password'];
  $username = $firstname[0] . $lastname ."1911";
  $sql = "SELECT * FROM users WHERE  email='$email' LIMIT 1";
  if ($result=mysqli_query($conn,$sql))
  {
    // Check no of rows
    if(mysqli_num_rows($result))
    {
      $_SESSION['response'] = "Email address in use";
      mysqli_close($conn);
      exit();
    }
    else{
    $query = "INSERT INTO users (firstname, lastname, email, dob, password, username)
       VALUES(?,?,?,?,?,?)";
    $stmt =$conn->prepare($query);
    $stmt->bind_param("ssssss",$firstname,$lastname,$email,$dob,$password,$username);
    $stmt->execute();
  }
  header('location:usertable.php');
  $_SESSION['response'] = "Successfully Inserted into the database";
  $_SESSION['res_type'] ="Success";
  }
}
 ?>
