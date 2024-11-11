<?php
$servername = "localhost:3308"; // Enter Your severname here
$username = "root"; // Enter your MySQL database username here
$password = ""; // // Enter your MySQL database password here
$dbname = "e_com_sport"; // Enter your Database Name here

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
