<?php
$servername = "localhost"; // Enter Your severname here
$username = "root"; // Enter your MySQL database username here
$password = ""; // // Enter your MySQL database password here
$dbname = "eshop"; // Enter your Database Name here

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}