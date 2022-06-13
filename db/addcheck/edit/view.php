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
    <link rel="stylesheet" href="/db/addcheck/edit/view_style.css">
    <link rel="stylesheet" href="/style_master.css">
  </head>

  <body>

    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";

    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $_SESSION["uid"] = $_GET["id"];
      $sqltest = "SELECT COUNT(IdCreate) FROM createcheck WHERE IdCreate = '" . $_GET["id"] . "'";
      $sql = "SELECT c.IdCreate, u.name, u.surname, u.number, c.createdate, a.name, c.finishdate, c.checkADCreate, c.checkADMod, c.checkNotesCreate, c.checkNotesMod, c.checkTelCreate, c.checkIQSCreate, c.checkWACreate, c.checkHWSWCreate, c.checkWelcomeCreate, u.needswinuser, u.needsmailuser, u.needstelintern, u.needstelmobile, c.comment, u.email, u.telintern, u.telmobile, u.shorty, u.needssap, u.sappassword, u.example, u.location, u.workstart, u.winexample, u.winextra, u.mailgroups, u.comment FROM createcheck AS c LEFT JOIN createuser AS u ON c.fkIdUser = u.idUser LEFT JOIN adminusers AS a ON c.fkIdAdminusers = a.idAdminUser WHERE c.IdCreate = '" . $_GET["id"] . "'";
    } else {
      echo "<p>Es wurde keine Checkliste ausgewählt.</p>";
      echo "<a href='/db/addcheck/edit/index.php'>Checkliste auswählen</a>";
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

            //set data for Welcome PDF
            $_SESSION["welcomeinfo"] = array($checklist[3], $checklist[24], $checklist[17], $checklist[21], $checklist[22], $checklist[23], $checklist[16], $checklist[25], $_GET["id"], $checklist[26]);
          }
    }

    ?>
    <h1>Checkliste User erfassen</h1>
    <h4><?php echo $checklist[1] . ", " . $checklist[2] . " (" . $checklist[3] . ")" ?></h4> <hr>
    <div class="invisiblecontainer">
      <p><?php echo "Erstellt am: " . $checklist[4] . " von: " . $checklist[5] ?></p>

      <?php
      //get last save timestamp if set
      if (isset($_SESSION["lastsave"]) && $_SESSION["lastsave"] != "") {
        echo "<p>Letzte Speicherung: " . $_SESSION["lastsave"];
        unset($_SESSION["lastsave"]);
      } else {
        echo "<p>Letzte Speicherung: Noch nicht gespeichert";
      }
      ?>
    </div>
    <hr>
    <div class="invisiblecontainer">
      <form class="checklist" action="/db/addcheck/edit/send.php" method="post">
        <input type="checkbox" name="ADCreate" <?php if (isset($checklist)) { if ($checklist[7] == "on") { echo " checked"; } if ($checklist[16] != "on") { echo " disabled"; } } ?>>
        <p class="info">AD User erstellt</p> <br>

        <input type="checkbox" name="ADMod" <?php if (isset($checklist)) { if ($checklist[8] == "on") { echo "checked"; } if ($checklist[16] != "on") { echo " disabled"; } } ?>>
        <p class="info">AD User bearbeitet</p> <br>

        <input type="checkbox" name="NotesCreate" <?php if (isset($checklist)) { if ($checklist[9] == "on") { echo "checked"; } if ($checklist[17] != "on") { echo " disabled"; } } ?>>
        <p class="info">Notes User erstellt</p> <br>

        <input type="checkbox" name="NotesMod" <?php if (isset($checklist)) { if ($checklist[10] == "on") { echo "checked"; } if ($checklist[17] != "on") { echo " disabled"; } } ?>>
        <p class="info">Notes User bearbeitet</p> <br>

        <input type="checkbox" name="TelCreate" <?php if (isset($checklist)) { if ($checklist[11] == "on") { echo "checked"; } if ($checklist[18] != "on" && $checklist[19] != "on") { echo " disabled"; } } ?>>
        <p class="info">Telefon-Nummer zugewiesen</p> <br>

        <input type="checkbox" name="IQSCreate" <?php if (isset($checklist)) { if ($checklist[12] == "on") { echo "checked"; } } ?>>
        <p class="info">IQ-Soft User erstellt</p> <br>

        <input type="checkbox" name="WACreate" <?php if (isset($checklist)) { if ($checklist[13] == "on") { echo "checked"; } } ?>>
        <p class="info">Webaccess User erstellt</p> <br>

        <input type="checkbox" name="HWSWCreate" <?php if (isset($checklist)) { if ($checklist[14] == "on") { echo "checked"; } } ?>>
        <p class="info">HW&SW Eintrag erstellt / editiert</p> <br>

        <input type="checkbox" name="WelcomeCreate" <?php if (isset($checklist)) { if ($checklist[15] == "on") { echo "checked"; } } ?>>
        <p class="info">Wilkommensblatt erstellt</p> <br>
        <br> <a class="button" href="/db/addcheck/edit/welcomepage/select.php">Willkommensblatt erstellen</a>

        <p>Kommentar</p>
        <textarea name="comment" rows="5" cols="40"><?php if (isset($checklist)) { echo $checklist[20]; } ?></textarea> <br>

        <input type="checkbox" name="finished" <?php if (isset($checklist)) { if ($checklist[6] != "") { echo "checked"; } } ?>>
        <p class="info">Erfassen abgeschlossen</p> <hr>

        <input type="hidden" name="sendA" value="editcreate">
        <input name="submit" type="submit" value="Änderungen übernehmen">
        <input name="submit" type="submit" value="Änderungen übernehmen und zurück zum Menu">
      </form>
    </div>
    <hr>
    <div class="invisiblecontainer">
      <h3>User Infos</h3>

      <table class="infotable">
        <?php if ($checklist[1] != "") { echo "<tr><th>Name</th><th>" . $checklist[1] . " " . $checklist[2] . "</th></tr>"; } ?>
        <?php if ($checklist[24] != "") { echo "<tr><th>Kürzel</th><th>" . $checklist[24] . "</th></tr>"; } ?>
        <?php if ($checklist[3] != "") { echo "<tr><th>Personalnr.</th><th>" . $checklist[3] . "</th></tr>"; } ?>
        <?php if ($checklist[28] != "") { echo "<tr><th>Standort</th><th>" . $checklist[28] . "</th></tr>"; } ?>
        <?php if ($checklist[29] != "") { echo "<tr><th>Startdatum</th><th>" . $checklist[29] . "</th></tr>"; } ?>
        <?php if ($checklist[27] != "") { echo "<tr><th>Vorbild allg.</th><th>" . $checklist[27] . "</th></tr>"; } ?>
        <?php if ($checklist[30] != "") { echo "<tr><th>Vorbild Win</th><th>" . $checklist[30] . "</th></tr>"; } ?>
        <?php if ($checklist[31] != "") { echo "<tr><th>Win extra-perms</th><th>" . $checklist[31] . "</th></tr>"; } ?>
        <?php if ($checklist[21] != "") { echo "<tr><th>E-Mail</th><th>" . $checklist[21] . "</th></tr>"; } ?>
        <?php if ($checklist[32] != "") { echo "<tr><th>Mailgruppen</th><th>" . $checklist[32] . "</th></tr>"; } ?>
        <?php if ($checklist[22] != "") { echo "<tr><th>tel. Intern</th><th>" . $checklist[22] . "</th></tr>"; } ?>
        <?php if ($checklist[23] != "") { echo "<tr><th>tel. Mobil</th><th>" . $checklist[23] . "</th></tr>"; } ?>
        <?php if ($checklist[33] != "") { echo "<tr><th>Kommentar</th><th>" . $checklist[33] . "</th></tr>"; } ?>
      </table>
    </div>
  </body>
</html>
