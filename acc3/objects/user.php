<?php

class User{
  private $conn;
  privat $table_name = "users";


  //user properties
  public $id;
  public $username;
  public $emai;
  public $password;
  public $status;
  public $role;
  public $dob;
  public $created_at;
  public $updated_at;
  public $firstname;
  public $lastname;

  // constructor
  public function __construct($db){
    $this->conn = $db;
  }
  

  ?>
