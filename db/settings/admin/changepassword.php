<?php session_start();

if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progess...");
} else {
  $_SESSION['logged_in'] = true;
}
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style_master.css">
    <title>Passwort wechseln</title>
  </head>
  <body>
    <h1>Passwort wechseln</h1>
    <h3>Wechseln Sie das Passwort für Ihren User</h3> <hr>
    <div class="invisiblecontainer">
      <form class="changepassword" action="/db/settings/admin/sendpassword.php" method="post">
        <input type="password" name="oldpassword" placeholder="Altes Kennwort" required> <br> <br>
        <input type="password" name="newpassword" placeholder="Neues Kennwort" required>
        <input type="password" name="newpasswordrepeat" placeholder="Kennwort wiederholen" required> <br> <br>
        <input type="hidden" name="sendA" value="changepw">
        <input type="submit" value="Kennwort ändern">
      </form> <hr> <br>
      <a class="button" href="/db/index.php">Zurück zum Menu</a>
    </div>
  </body>
</html>
