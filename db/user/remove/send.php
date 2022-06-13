<?php session_start();

if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progress...");
} else {
  $_SESSION['logged_in'] = true;
  if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] < 3) {
    echo "<a href='/index.php'>Mit anderem User anmelden</a> <br>";
    die("Der angemeldete user hat kein Zugriffsrecht auf diese Seite.");
  }
}

if (isset($_POST["sendA"]) && $_POST["sendA"] == "deleteuser")  {
  unset($_POST["sendA"]);
} else {
  die("Nichts zu senden / Wurde bereits gesendet.");
}
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User löschen</title>
    <link rel="stylesheet" href="/style_master.css">
  </head>
  <body>
    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";
    $sql = "DELETE FROM createuser WHERE idUser = '" . $_POST["uiddelete"] . "'";

    $sqlca = "SELECT COUNT(idCreate) FROM createcheck WHERE fkIdUser = '" . $_POST["uiddelete"] . "'";
    $sqlda = "DELETE FROM createcheck WHERE fkIdUser = '" . $_POST["uiddelete"] . "'";

    $sqlcd = "SELECT COUNT(idDelete) FROM deletecheck WHERE fkIdUser = '" . $_POST["uiddelete"] . "'";
    $sqldd = "DELETE FROM deletecheck WHERE fkIdUser = '" . $_POST["uiddelete"] . "'";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("<p>Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!</p>");
    } else {
          $countcreate = mysqli_fetch_array(mysqli_query($conn, $sqlca));
          //echo "<p>Count Create: " . $countcreate . "</p>";
          if ($countcreate[0] == 1) {
            if ($conn->query($sqlda) === TRUE) {
              echo "<p>Erfassen Checkliste für diesen User wurde gelöscht.</p>";
            } else {
              echo "<p>Die Erfassen Checkliste für den User konnte nicht gelöscht werden!</p>";
              die("<a href='/db/index.php'>Zurück zum Menu</a>");
            }
          }

          $countdelete = mysqli_fetch_array(mysqli_query($conn, $sqlcd));
          //echo "<p>Count Delete: " . $countdelete . "</p>";
          if ($countdelete[0] == 1) {
            if ($conn->query($sqldd) === TRUE) {
              echo "<p>Löschen Checkliste für diesen User wurde gelöscht.</p>";
            } else {
              echo "<p>Die Löschen Checkliste für den User konnte nicht gelöscht werden!</p>";
              die("<a href='/db/index.php'>Zurück zum Menu</a>");
            }
          }

          if ($conn->query($sql) === TRUE) {
            echo "<p>Der User wurde gelöscht.</p>";
          } else {
            echo "<p>Der User konnte nicht gelöscht werden!</p>";
          }
    }
    echo "<a class='button' href='/db/index.php'>Zurück zum Menu</a>";
    ?>
  </body>
</html>
