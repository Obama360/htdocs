<?php session_start();

if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progess...");
} else {
  $_SESSION['logged_in'] = true;
}

if (isset($_POST["sendA"]) && $_POST["sendA"] == "changepw")  {
  unset($_POST["sendA"]);
} else {
  die("Nichts zu senden / Wurde bereits gesendet.");
}
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style_master.css">
    <title>User Erfassen</title>
  </head>
  <body>
    <h1>Passwort wechseln</h1>
    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";
    $sql = "SELECT COUNT(username) FROM adminusers WHERE username = '" . $_SESSION['adminuser'] . "' AND password = MD5('" . $_POST["oldpassword"] . "')";
    $sqlset = "UPDATE adminusers SET password = MD5('" . $_POST["newpassword"] . "') WHERE username = '" . $_SESSION['adminuser'] . "' AND password = MD5('" . $_POST["oldpassword"] . "')";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          // Getting data
          $answer = mysqli_fetch_array(mysqli_query($conn, $sql));

          //processing data
          if ($answer[0] == 1) {
            if (strlen($_POST["newpassword"]) >= 8 && $_POST["newpassword"] != $_POST["oldpassword"]) {
              if ($_POST["newpassword"] == $_POST["newpasswordrepeat"]) {
                if ($conn->query($sqlset) === TRUE) {
                  echo "<p>Das Passwort wurde erfolgreich geändert.</p>";
                } else {
                  echo "<p>Das Kennwort konnte aus mysteriösen Gründen nicht geändert werden :(</p>";
                  echo "<a class='button' href='/db/settings/admin/changepassword.php'>Zurück zum Passwortwechsel</a> <br>";
                }
              } else {
                echo "<p>Die neuen Kennwörter stimmen nicht überein!</p>";
                echo "<a class='button' href='/db/settings/admin/changepassword.php'>Zurück zum Passwortwechsel</a> <br>";
              }
            } else {
              echo "<p>Das neue Passwort ist kürzer als 8 Zeichen oder ist dem alten zu ähnlich!</p>";
              echo "<a class='button' href='/db/settings/admin/changepassword.php'>Zurück zum Passwortwechsel</a> <br>";
            }
          } else {
            echo "<p>Das eingegebene Kennwort ist nicht korrekt.</p>";
            echo "<a class='button' href='/db/settings/admin/changepassword.php'>Zurück zum Passwortwechsel</a> <br>";
          }
    }
     ?>
     <br> <a class="button" href="/db/index.php">Zurück zum Menu</a>
  </body>
</html>
