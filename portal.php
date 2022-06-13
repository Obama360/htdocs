<?php session_start();
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Useradmin - Portal</title>
    <link rel="stylesheet" href="/style_master.css">
    <link rel="stylesheet" href="/portal.css">
  </head>
  <body>

    <h1>Willkommen bei der Useradministration</h1>
    <div class="scene">
      <img id="logo" src="/images/logo.gif" alt="Useradministration Logo">
    </div>
    <h3>Was möchten Sie heute erledigen?</h3>

    <div class="cell3">
      <div class="create_button">
        <div class="portal">
          <img src="/images/entry.png" alt="Bild Eintritt">
          <div class="ellipse blue"></div>
          <h5>Eintritt melden</h5>
        </div>

      </div>
      <hr>
      <div class="delete_button">
        <div class="portal">
          <img src="/images/leavo.png" alt="Bild Austritt">
          <div class="ellipse orange"></div>
          <h5>Austritt melden</h5>
        </div>
      </div>
    </div>
    <div class="invisiblecontainer">
      <hr>
      <h4>Sie haben Zugangsdaten?</h4>
      <a href="/index.php" class="button centerbutton">Zum Admin Login</a>
    </div>
    <br>
    <hr>
    <div class="footer">
      <p id="time"></p>
      <p class="centertext">Useradmin Version 1.13 (2022-01)</p>
      <p class="righttext">Duscholux AG 3604 Thun</p>
    </div>
    <script type="text/javascript">
    var timeP = document.getElementById("time");

    function refreshTime() {
      var dateString = new Date().toLocaleString("de-DE", {timeZone: "Europe/Zurich"});
      var formattedString = dateString.replace(", ", " - ");
      timeP.innerHTML = formattedString;
}
    refreshTime()
    setInterval(refreshTime, 1000);
    </script>
  </body>
</html>
