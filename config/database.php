<?php
class Database{
  private $host = "accountantdb.cecg8fpgzvzf.us-east-1.rds.amazonaws.com";
  private $db_name = "theaccdb";
  private $username = "root";
  private $password = "admin123";
  public $conn;
  public function getConnection(){

          $this->conn = null;

          try{
              $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
          }catch(PDOException $exception){
              echo "Connection error: " . $exception->getMessage();
          }

          return $this->conn;
      }
  }
  ?>
