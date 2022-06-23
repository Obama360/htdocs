<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SESSION['logged_in'] != true) {
  echo "Datenabfrage verboten!";
  die();
} else {
  $_SESSION['logged_in'] = true;

  //Process Query
  $servername = "localhost";
  $username = "userlister";
  $db = "userlist";

  // Create connection
  $conn = new mysqli($servername, $username, "", $db);

  // Retrieve and display data
  print_r(json_encode( mysqli_fetch_array(mysqli_query($conn, $_GET["q"]))));
}
?>
