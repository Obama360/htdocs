<?php session_start();
error_reporting(E_ERROR | E_PARSE); //don't show infos like unset variables

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

if (isset($_POST["sendA"]) && $_POST["sendA"] == "editcreate")  {
  unset($_POST["sendA"]);
} else {
  echo "<script> location.href='/db/index.php'; </script>";
  die("Nichts zu senden / Wurde bereits gesendet.");
}
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Checkliste editieren</title>
    <link rel="stylesheet" href="/style_master.css">
  </head>
  <body>
    <?php

    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";

    //set time zone for timestamps
    date_default_timezone_set("Europe/Zurich");
    $time = time();

    //set sql if user-id provided
    if (isset($_SESSION["uid"]) && $_SESSION["uid"] != "") {

      //check if finished has been checked
      if (isset($_POST["finished"]) && $_POST["finished"] == "on") {
        $finishdate = date("Y-m-d",$time);
      } else {
        $finishdate = ""; //set anyways so it is declared
      }

      $sqlset = "UPDATE createcheck SET checkADCreate = '" . $_POST["ADCreate"] . "', finishdate = '" . $finishdate . "', checkADMod = '" . $_POST["ADMod"] . "', checkNotesCreate = '" . $_POST["NotesCreate"] . "', checkNotesMod = '" . $_POST["NotesMod"] . "', checkTelCreate = '" . $_POST["TelCreate"] . "', checkIQSCreate = '" . $_POST["IQSCreate"] . "', checkWACreate = '" . $_POST["WACreate"] . "', checkHWSWCreate = '" . $_POST["HWSWCreate"] . "', checkWelcomeCreate = '" . $_POST["WelcomeCreate"] . "', comment = '" . $_POST["comment"] . "' WHERE idCreate = '" . $_SESSION["uid"] . "'";
    } else {
      echo "<p>Der Eintrag wurde bereits bearbeitet.</p>";
      echo "<a href='/db/addcheck/edit/index.php'>Andere Checkliste auswählen</a>";
      echo "<a href='/db/index.php'>Zurück zum Menu</a>";
      die();
    }

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          //removing global uid to prevent double entries on site reload
          $uid = $_SESSION["uid"];
          unset($_SESSION["uid"]);
          //setting data
          if ($conn->query($sqlset) === TRUE) {
            $_SESSION["lastsave"] = date("H:i:s");

            //redirect to menu if back to menu has been selected. Else back to Checklist
            if (isset($_POST["submit"]) && $_POST["submit"] == "Änderungen übernehmen und zurück zum Menu") {
              echo "<script> location.href='/db/index.php'; </script>";
            } else {
              echo "<script> location.href='/db/addcheck/edit/view.php?id=". $uid . "'; </script>";
            }

          } else {
            echo "Die Checkliste konnte nicht angelegt werden!";
            echo "<a href='/db/addcheck/create/index.php'>Anderen User auswählen</a>";
            die ("Query: " . $sqlset);
          }
    }
    ?>
    <a href='/db/index.php'>Zurück zum Menu</a>
  </body>
</html>
