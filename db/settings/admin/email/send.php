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

if (isset($_POST["sendA"]) && $_POST["sendA"] == "editmail")  {
  unset($_POST["sendA"]);
} else {
  die("Nichts zu senden / Wurde bereits gesendet.");
}
 ?>

 <!DOCTYPE html>
 <html lang="de" dir="ltr">
   <head>
     <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
     <meta charset="utf-8">
     <title>Email Listen bearbeiten</title>
     <link rel="stylesheet" href="/style_master.css">
   </head>
   <body>
     <?php
     $servername = "localhost";
     $username = "userlister";
     $db = "userlist";

     // Create connection
     $conn = new mysqli($servername, $username, "", $db);

     if (isset($_POST["email"]) && $_POST["email"] != "" && isset($_POST["mailgroup"]) && $_POST["mailgroup"] != "") {
       $sql = "INSERT INTO maillist (email, mailgroup) VALUES ('". $_POST["email"] . "', '" . $_POST["mailgroup"] . "')";

       if ($conn->connect_error) {
         die("<p>Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!</p>");
       } else {
         if ($conn->query($sql) === TRUE) {
           echo "<p>Die Email wurde erfolgreich hinzugefügt</p>";
         } else {
           echo "<p>Die Email konnte nicht hinzugefügt werden!</p>";
           echo "<a class='button' href='/db/index.php'> Zurück zum Menu</a>";
           die();
         }
     }
   } elseif (isset($_POST["mailremove"]) && $_POST["mailremove"] != "") {
     $sqldel = "DELETE FROM maillist WHERE IdMaillist = '" . $_POST["mailremove"] . "'";
     if ($conn->query($sqldel) === TRUE) {
       echo "<p>Die Email wurde erfolgreich entfernt</p>";
     } else {
       echo "<p>Die Email konnte nicht entfernt werden!</p>";
       echo "<a href='/db/index.php'> Zurück zum Menu</a>";
       die();
     }
   } else {
     echo "<p>Es wurde keine E-Mail angegeben</p>";
   }
   echo "<a class='button' href='/db/index.php'> Zurück zum Menu</a>";
     ?>
   </body>
 </html>
