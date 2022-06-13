<?php session_start();
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Useradmin login</title>
    <link rel="stylesheet" href="/style_master.css">
    <link rel="stylesheet" href="/intro.css">
  </head>
  <body>

    <!--
    <script type="text/javascript">alert("====== Die Seite wird zurzeit bearbeitet ====== \n\nDie Seite kann weiterhin verwendet werden, es kann jedoch zu Problemen und Unterbrüchen kommen!")</script>
    -->

    <h1>Useradministration Admin Login</h1>
    <div class="scene">
      <img id="logo" src="/images/logo.gif" alt="Useradministration Logo">
    </div>
    <h3>Bitte loggen sie sich ein um fortfahren zu können</h3>

    <div class="invisiblecontainer">
      <a class="button" href="/portal.php">Zurück zum Portal</a>
      <hr>
      <?php
      if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "true") {
        echo "<script> location.href='/db/index.php'; </script>";
      }

      //the following line was borrowed from https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
      $currenturl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      if (isset($_SESSION['loginfailed']) && $_SESSION['loginfailed'] == "true") {
        unset($_SESSION['loginfailed']);
        echo "<p>Die eingegebenen Daten waren falsch, bitte versuchen Sie es erneuert.</p>";
      }
      if (isset($_SESSION['loginfailed']) && $_SESSION['loginfailed'] == "logout") {
        unset($_SESSION['loginfailed']);
        echo "<p>Logout erfolgreich.</p>";
      } else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] . "index.php" != $currenturl && $_SERVER['HTTP_REFERER'] != $currenturl) {
          echo "<p>Redirect: " . $_SERVER['HTTP_REFERER'] . "</p>";
          //echo "<p>This site: $currenturl</p>";
          $_SESSION["redirect"] = $_SERVER['HTTP_REFERER'];
        }
      }
      ?>
      <form action="/login.php" method="post">
        <div class="login">
          <div class="div1">
            <p class="righttext">Username:</p>
          </div>

          <div class="div2">
            <input type="text" name="username" required>
          </div>

          <div class="div3">
            <p class="righttext">Passwort:</p>
          </div>

          <div class="div4">
            <input type="password" name="password" required>
          </div>

          <div class="div5">
            <input type="submit" value="Login">
          </div>
        </div>
      </form>
      <hr>
      <p>Bei vergessenen Anmeldedaten bitte das EDV Team kontaktieren!</p>
    </div>
    <br>
  </body>
</html>
