<?php session_start();
echo "Logout erfolgt...";
if ($_SESSION['logged_in'] == true) {
  $_SESSION['logged_in'] = "false";
  $_SESSION['adminuser'] = null;
  unset($_SESSION['logged_in']);
  unset($_SESSION['adminuser']);
  $_SESSION['loginfailed'] = "logout";
  header('Location: ' . "/index.php", true, 301);
  die();
}
 ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Logout</title>
    <link rel="stylesheet" href="/style_master.css">
  </head>
  <body>
    <h1>Logout...</h1>
  </body>
</html>
