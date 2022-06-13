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
     <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
     <meta charset="utf-8">
     <title>Email Listen bearbeiten</title>
     <link rel="stylesheet" href="/style_master.css">
   </head>
   <body>
     <h1>E-Mail Listen bearbeiten</h1>
     <h3>Emails hinzufügen und löschen</h3> <hr>
     <div class="invisiblecontainer">
       <h4>Email Hinzufügen: </h4>
       <form class="addmail" action="/db/settings/admin/email/send.php" method="post">
         <input type="text" name="email" placeholder="E-Mail" required>
         <select name="mailgroup">
           <option value="0">HR Email</option>
           <option value="1">EDV Email</option>
           <option value="2">Info Email</option>
         </select> <br>

         <input type="hidden" name="sendA" value="editmail">
         <input type="submit" value="Email hinzufügen">
       </form>
       <hr>
       <h4>Email entfernen:</h4>
       <?php
       $servername = "localhost";
       $username = "userlister";
       $db = "userlist";
       $sql = "SELECT idMaillist, email, mailgroup FROM maillist";

       // Create connection
       $conn = new mysqli($servername, $username, "", $db);

       if ($conn->connect_error) {
         die("<p>Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!</p>");
       } else {
         $emails = mysqli_query($conn, $sql);
      }


       ?>
       <form class="removemail" action="/db/settings/admin/email/send.php" method="post">
         <select name="mailremove">
           <?php while($mail = mysqli_fetch_array($emails)):; ?>
             <?php if ($mail[2] == 0) { $group = "HR"; } elseif ($mail[2] == 1) { $group = "EDV"; } elseif ($mail[2] == 2) { $group = "Info"; } ?>
             <option value="<?php echo $mail[0] ?>"><?php echo $mail[1] . " / " . $group ?></option>
           <?php endwhile; ?>
         </select>

         <input type="hidden" name="sendA" value="editmail">
         <input type="submit" value="Email entfernen">
       </form>
       <hr> <br> <a class="button" href="/db/index.php">Zurück zum Menu</a>
     </div>
   </body>
</html>
