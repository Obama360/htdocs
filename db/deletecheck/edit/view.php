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
    <title>Erfassen Checkliste editieren</title>
    <link rel="stylesheet" href="/style_master.css">
    <link rel="stylesheet" href="/db/deletecheck/edit/view_style.css">
  </head>

  <body>

    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";

    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $_SESSION["uid"] = $_GET["id"];
      $sqltest = "SELECT COUNT(IdDelete) FROM deletecheck WHERE IdDelete = '" . $_GET["id"] . "'";
      $sql = "SELECT c.IdDelete, u.name, u.surname, u.number, c.createdate, a.name, c.finishdate, c.checkADDelete, c.checkNotesDelete, c.checkTelDelete, c.checkIQSDelete, c.checkWADelete, c.checkHWSWDelete, u.needswinuser, u.needsmailuser, u.needstelintern, c.comment FROM deletecheck AS c LEFT JOIN createuser AS u ON c.fkIdUser = u.idUser LEFT JOIN adminusers AS a ON c.fkIdAdminusers = a.idAdminUser WHERE c.IdDelete = '" . $_GET["id"] . "'";
    } else {
      echo "<p>Es wurde keine Checkliste ausgewählt.</p>";
      echo "<a href='/db/deletecheck/edit/index.php'>Checkliste auswählen</a>";
      echo "<a href='/db/index.php'>Zurück zum Menu</a>";
      die();
    }

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          //testing if entry exists
          $entryamount = mysqli_fetch_array(mysqli_query($conn, $sqltest));

          if ($entryamount[0] != 1) {
            echo "<p>Diese Checkliste existiert nicht!<p>";
            echo "<a href='/db/addcheck/edit/index.php'>Andere Checkliste auswählen</a>";
            echo "<a href='/db/index.php'>Zurück zum Menu</a>";
            die();
          } else {
            // Getting Data
            //echo "Getting data with query: " . $sql;
            $checklist = mysqli_fetch_array(mysqli_query($conn, $sql));

          }
    }

    ?>
    <h1>Checkliste User löschen</h1>
    <h4><?php echo $checklist[1] . ", " . $checklist[2] . " (" . $checklist[3] . ")" ?></h4>
     <hr>

    <div class="invisiblecontainer">
      <p><?php echo "Erstellt am: " . $checklist[4] . " von: " . $checklist[5] ?></p>
      <?php
      //get last save timestamp if set
      if (isset($_SESSION["lastsave"]) && $_SESSION["lastsave"] != "") {
        echo "<p>Letzte Speicherung: " . $_SESSION["lastsave"];
        unset($_SESSION["lastsave"]);
      } else {
        echo "<p>Letzte Speicherung: Noch nicht gespeichert</p>";
      }
      ?>
    </div>

    <hr>
    <div class="invisiblecontainer">
      <form class="checklist" action="/db/deletecheck/edit/send.php" method="post">
        <input type="checkbox" name="ADDelete" <?php if (isset($checklist)) { if ($checklist[7] == "on") { echo " checked"; } if ($checklist[13] != "on") { echo " disabled"; } } ?>>
        <p class="info">AD User gelöscht</p> <br>

        <input type="checkbox" name="NotesDelete" <?php if (isset($checklist)) { if ($checklist[8] == "on") { echo "checked"; } if ($checklist[14] != "on") { echo " disabled"; } } ?>>
        <p class="info">Notes User Gelöscht</p> <br>

        <input type="checkbox" name="TelDelete" <?php if (isset($checklist)) { if ($checklist[9] == "on") { echo "checked"; } if ($checklist[15] != "on") { echo " disabled"; } } ?>>
        <p class="info">Internet Telefonnummer frei gemacht</p> <br>

        <input type="checkbox" name="IQSDelete" <?php if (isset($checklist)) { if ($checklist[10] == "on") { echo "checked"; } } ?>>
        <p class="info">IQ-Soft User gelöscht</p> <br>

        <input type="checkbox" name="WADelete" <?php if (isset($checklist)) { if ($checklist[11] == "on") { echo "checked"; } } ?>>
        <p class="info">Webaccess User Gelöscht</p> <br>

        <input type="checkbox" name="HWSWDelete" <?php if (isset($checklist)) { if ($checklist[12] == "on") { echo "checked"; } } ?>>
        <p class="info">HW&SW Eintrag gelöscht / editiert</p> <br>

        <p>Kommentar</p>
        <textarea name="comment" rows="5" cols="40"><?php if (isset($checklist)) { echo $checklist[16]; } ?></textarea> <br>

        <input type="checkbox" name="finished" <?php if (isset($checklist)) { if ($checklist[6] != "") { echo "checked"; } } ?>>
        <p class="info">Löschung abgeschlossen</p> <hr>

        <input type="hidden" name="sendA" value="editdelete">
        <input name="submit" type="submit" value="Änderungen übernehmen">
        <input name="submit" type="submit" value="Änderungen übernehmen und zurück zum Menu">
      </form>
    </div>
  </body>
</html>
