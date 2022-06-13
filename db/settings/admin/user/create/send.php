<?php session_start();

if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progess...");
} else {
  $_SESSION['logged_in'] = true;
  if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] < 9) {
    echo "<a href='/index.php'>Mit anderem User anmelden</a> <br>";
    die("Der angemeldete user hat kein Zugriffsrecht auf diese Seite.");
  }
}

if (isset($_POST["sendA"]) && $_POST["sendA"] == "createadmin")  {
  unset($_POST["sendA"]);
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
    //check if password matches with confirm
    if (isset($_POST["password"]) && isset($_POST["passwordconfirm"]) && $_POST["password"] == $_POST["passwordconfirm"]) {
      $sql = "INSERT INTO adminusers (username, password, name, level) VALUES ('" . $_POST["username"] . "', MD5('" . $_POST["password"] . "'), '" . $_POST["name"] . "', '" . $_POST["level"] . "')";
    } else {
      echo "<p>Die Passwörter stimmen nicht überein oder wurden nicht angegeben.</p>";
      echo "<a href='/db/settings/admin/user/create/index.php>Zurück zum user erstellen</a>";
      die();
    }

    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("<p>Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!</p>");
    } else {
      if ($conn->query($sql) === TRUE) {
        echo "<p>Der Admin User wurde erfolgreich erstellt</p>";
      } else {
        echo "<p>Der neue User konnte nicht erstellt werden!</p>";
      }
      echo "<a class='button' href='/db/index.php'>Zurück zum Menu</a>";
    }
    ?>
  </body>
</html>
