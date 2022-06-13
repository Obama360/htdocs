<?php session_start();
error_reporting(E_ERROR | E_PARSE); //don't show infos like unset variables

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

    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $_SESSION["aid"] = $_GET["id"];
      $sql = "SELECT username, name, level FROM adminusers WHERE idAdminUser = '" . $_GET["id"] . "'";
    } else {
      echo "<p>Es wurde kein Admin User angegeben</p>";
      die("<a href='/db/settings/admin/user/index.php'>Admin User auswählen</a>");
    }

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          // Getting Data
          $admininfo =  mysqli_fetch_array(mysqli_query($conn, $sql));
    }

    ?>
    <h1>Admin User anpassen</h1>
    <h3>Passen Sie den ausgewählten user an.</h3> <hr>
    <div class="invisiblecontainer">
          <h4>User Infos bearbeiten:</h4>
          <form class="editadminuserinfos" action="/db/settings/admin/user/edit/send.php" method="post">
            <p class="info">Username: </p> <input type="text" name="ausername" <?php if (isset($admininfo)) { echo "value='" . $admininfo[0] . "'"; } ?> required> <br>
            <p class="info">Name: </p> <input type="text" name="aname" <?php if (isset($admininfo)) { echo "value='" . $admininfo[1] . "'"; } ?> required> <br>

             <p class="info">Level: </p> <select name="alevel">
              <option <?php if(isset($admininfo) && $admininfo != "") { if ($admininfo[2] == 0) { echo "selected"; }} ?> value="0">Viewer (Keine Rechte)</option>
              <option <?php if(isset($admininfo) && $admininfo != "") { if ($admininfo[2] == 5) { echo "selected"; }} ?> value="5">HR Normal</option>
              <option <?php if(isset($admininfo) && $admininfo != "") { if ($admininfo[2] == 7) { echo "selected"; }} ?> value="7">EDV Normal</option>
              <option <?php if(isset($admininfo) && $admininfo != "") { if ($admininfo[2] == 9) { echo "selected"; }} ?> value="9">EDV Admin</option>
            </select> <br>

            <input type="hidden" name="sendA" value="editadminuser">
            <input type="submit" value="Änderungen übernehmen">
          </form>

          <hr>
          <h4>User Passwort zurücksetzen:</h4>
          <form class="editadminuserpassword" action="/db/settings/admin/user/edit/send.php" method="post">
            <p class="info">Neues Passwort: </p> <input type="password" name="apassword" required>

            <input type="hidden" name="sendA" value="resetadminuser">
            <input type="submit" value="Passwort zurücksetzen">
          </form> <hr>
          <a class="button" href="/db/index.php">Zurück zum Menu</a>
    </div>

  </body>
</html>
