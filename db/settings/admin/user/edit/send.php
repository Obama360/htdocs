<?php session_start();

if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progess...");
} else {
  $_SESSION['logged_in'] = true;
  if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] < 10) {
    echo "<a href='/index.php'>Mit anderem User anmelden</a> <br>";
    die("Der angemeldete user hat kein Zugriffsrecht auf diese Seite.");
  }
}

if (isset($_POST["sendA"]) && $_POST["sendA"] == "editadminuser" || $_POST["sendA"] == "resetadminuser")  {
  $sqlc = $_POST["sendA"];
  unset($_POST["sendA"]);
} else {
  die("Nichts zu senden / Wurde bereits gesendet.");
}
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin User editieren</title>
    <link rel="stylesheet" href="/style_master.css">
  </head>
  <body>
    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";

    if (isset($_SESSION["aid"]) && $_SESSION["aid"] != "") {
      if (isset($sqlc) && $sqlc == "editadminuser") {
        $sql = "UPDATE adminusers SET username = '" . $_POST["ausername"] . "', name = '" . $_POST["aname"] . "', level = '" . $_POST["alevel"] . "' WHERE idAdminUser = '" . $_SESSION["aid"] . "'";
      } elseif (isset($sqlc) && $sqlc == "resetadminuser") {
        $sql = "UPDATE adminusers SET password = MD5('" . $_POST["apassword"] . "') WHERE idAdminUser = '" . $_SESSION["aid"] . "'";
      } else {
        echo "<p>Es wurde kein Admin User angegeben</p>";
        die("<a href='/db/settings/admin/user/index.php'>Admin User auswählen</a>");
      }
    } else {
      echo "<p>Es wurde kein Admin User angegeben</p>";
      die("<a href='/db/settings/admin/user/edit/index.php'>Admin User auswählen<a>");
    }

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          // Setting Data
          if ($conn->query($sql) === TRUE) {
            echo "<p>Der Admin User wurde erfolgreich editiert</p>";
            unset($_SESSION["aid"]);
          } else {
            echo "<p>Der Admin User konnte nicht editiert werden!</p>";
          }
    }
    ?>
    <a href="/db/index.php">Zurück zum Menu</a>
</body>
</html>
