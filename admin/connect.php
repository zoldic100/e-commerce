<?php

$servername = "localhost";
$username = "root";
$password = "123456";
$db = "shop";
$port = '4306';
$dsn= 'mysql:port=4306;dbname=shop;host=localhost';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try {
    $conn = new PDO($dsn,$username,$password,
     );
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $connected= "Connected successfully";
  //echo 'connected';
  echo "<script>console.log('$connected');</script>";
  
} catch(PDOException $e) {
  $failed= "Connection failed: " . $e->getMessage();
  //echo "echo connected";
  echo "<script>console.log('$failed');</script>";

}
?>

