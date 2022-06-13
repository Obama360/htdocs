<?php session_start();

if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progess...");
} else {
  $_SESSION['logged_in'] = true;
  if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] < 3) {
    echo "<a href='/index.php'>Mit anderem User anmelden</a> <br>";
    die("Der angemeldete user hat kein Zugriffsrecht auf diese Seite.");
  }
}
 ?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User löschen bestätigen</title>
    <link rel="stylesheet" href="/style_master.css">
  </head>
  <body>

    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";
    if (isset($_GET["id"])) {
      $_SESSION["uid"] = $_GET["id"];
    } else {
      echo "<p>Es wurde kein User angegeben.</p>";
      echo "<a href='/db/index.php'>Zurück zum Menu</a>";
      die();
    }

    $sqltest = "SELECT COUNT(idUser) FROM createuser WHERE idUser = '" . $_SESSION["uid"] . "'";
    $sql = "SELECT name, surname, shorty, number FROM createuser WHERE idUser = '" . $_SESSION["uid"] . "'";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
      //checking if user exists
      $useramount = mysqli_fetch_array(mysqli_query($conn, $sqltest));

      //getting Data
      if ($useramount[0] == 1) {
        $userinfo = mysqli_fetch_array(mysqli_query($conn, $sql));
      } else {
        die("Es wurde kein Eintrag gefunden. (Einträge: " . $useramount[0] . ")");
      }
    }


    ?>
    <h1>Bestätigung User löschen</h1>
    <h3>Möchten Sie folgenden folgenden User löschen?</h3>
    <hr>
<div class="invisiblecontainer">
  <div class="container">
    <p>Name: <?php echo $userinfo[0]?></p>
    <p>Nachname: <?php echo $userinfo[1]?></p>
    <p>Personalnummer: <?php echo $userinfo[3]?></p>
    <p>Kürzel: <?php echo $userinfo[2]?></p>
  </div>

  <form class="confirmdelete" action="/db/user/remove/send.php" method="post">
    <input type="hidden" name="uiddelete" value="<?php echo $_SESSION["uid"] ?>">
    <input type="hidden" name="sendA" value="deleteuser">
    <input type="submit" value="User löschen">
  </form>

  <br> <a class="button marginmedium" href="/db/user/remove/index.php">Anderen User auswählen.</a> <br>
</div>
  </body>
</html>
