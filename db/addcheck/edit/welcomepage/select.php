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
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style_master.css">
    <title>Admin User erstellen</title>
  </head>
  <body>
    <h1>Willkommensblatt erstellen</h1>
    <h3>Erstellen Sie ein Willkommensblatt für einen neuen User</h3> <hr>

    <form class="createadminuser" action="/db/addcheck/edit/welcomepage/generate.php" method="post">
      <?php if (isset($_SESSION["welcomeinfo"]) && $_SESSION["welcomeinfo"][6] == "on") { echo "<input type='text' name='passwordwin' placeholder='* Windows Kennwort' required>"; } ?> <br>
      <?php if (isset($_SESSION["welcomeinfo"]) && $_SESSION["welcomeinfo"][2] == "on") { echo "<input type='text' name='passwordnotes' placeholder='* Notes Kennwort'required>"; } ?> <br>
      <?php if (isset($_SESSION["welcomeinfo"]) && $_SESSION["welcomeinfo"][7] == "on") { echo "<input type='text' name='passwordsap' placeholder='* SAP Kennwort' value='" . $_SESSION["welcomeinfo"][9] . "' required>"; } ?> <br>
      <input type="text" name="passwordtimetool" placeholder="* TimeTool Kennwort" required> <br>
      <input type="text" name="passwordsimmobile" placeholder="PIN SIM Mobile"> <br>
      <input type="text" name="passwordsimdata" placeholder="PIN SIM Data"> <br>

      <input type="submit" value="Willkommensblatt erstellen">
    </form> <br>
    <a class="button" href="/db/addcheck/edit/view.php?id=<?php if (isset($_SESSION["welcomeinfo"])) { echo $_SESSION["welcomeinfo"][8]; } ?>">Zurück zur Checkliste</a>
  </body>
</html>
