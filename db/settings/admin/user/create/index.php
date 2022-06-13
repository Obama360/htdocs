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
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style_master.css">
    <title>Admin User erstellen</title>
  </head>
  <body>
    <h1>Admin User erstellen</h1>
    <h3>Erstellen Sie einen neuen Admin User</h3> <hr>
    <div class="invisiblecontainer">
      <form class="createadminuser" action="/db/settings/admin/user/create/send.php" method="post">
        <input type="text" name="name" placeholder="Name" required> <br>
        <input type="text" name="username" placeholder="Username" required> <br>
        <input type="password" name="password" placeholder="Passwort" required>
        <input type="password" name="passwordconfirm" placeholder="Passwort wiederholen" required> <br>

        <select name="level">
          <option value="0">Viewer (Keine Rechte)</option>
          <option value="5">HR Normal</option>
          <option value="7">EDV Normal</option>
          <option value="9">EDV Admin</option>
        </select> <br>

        <input type="hidden" name="sendA" value="createadmin">
        <input type="submit" value="User erstellen">
      </form>
      <hr>
      <a class="button" href="/db/index.php">Zurück zum Menu</a>
    </div>
  </body>
</html>
