<?php session_start();

if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progess...");
} else {
  $_SESSION['logged_in'] = true;
  if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] < 7) {
    echo "<a href='/index.php'>Mit anderem User anmelden</a> <br>";
    die("Der angemeldete user hat kein Zugriffsrecht auf diese Seite.");
  }
}

if (isset($_SESSION["sendA"]) && $_SESSION["sendA"] == "createcreate")  {
  unset($_SESSION["sendA"]);
} else {
  die("Nichts zu senden / Wurde bereits gesendet.");
}
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Checkliste Erstellen anlegen</title>
    <link rel="stylesheet" href="/style_master.css">
  </head>
  <body>
    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";
    $sqlgetadmin = "SELECT idAdminUser FROM adminusers WHERE username = '" . $_SESSION['adminuser'] . "'";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("<p>Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!</p>");
    } else {
          // Getting data
          $adminid = mysqli_fetch_array(mysqli_query($conn, $sqlgetadmin));
          $time = time();
          $createdate = date("Y-m-d",$time);
          $sqlset = "INSERT INTO createcheck (createdate, fkIdAdminUsers, fkIdUser) VALUES ('" . $createdate . "', '" . $adminid[0] . "', '" . $_SESSION["uid"] . "')";
          $sqlget = "SELECT idCreate FROM createcheck WHERE createdate = '" . $createdate . "' AND fkIdAdminUsers = '" . $adminid[0] . "' AND fkIdUser = '" . $_SESSION["uid"] . "'";
          unset($_SESSION["uid"]);
          //setting data
          if ($conn->query($sqlset) === TRUE) {
            $checklistid = mysqli_fetch_array(mysqli_query($conn, $sqlget));
            echo "<p>Weiterleitung zur erstellten Checkliste erfolgt...</p>";
            echo "<script> location.href='/db/addcheck/edit/view.php?id=" . $checklistid[0] ."'; </script>";
          } else {
            echo "<p>Die Checkliste konnte nicht angelegt werden!</p>";
            echo "<a href='/db/addcheck/create/index.php'>Anderen User auswählen</a>";
            echo "<a href='/db/index.php'>Zurück zum Menu</a>";
            die ("Query: " . $sqlset);
          }
    }
    ?>
  </body>
</html>
