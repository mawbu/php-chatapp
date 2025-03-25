<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "chatapp";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
  echo "Database connection error" . mysqli_connect_error();
}

if (isset($_SESSION['unique_id'])) {
  $user_id = $_SESSION['unique_id'];
  $status = "Active now";
  mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$user_id}");
}
