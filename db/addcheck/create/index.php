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
    <title>User erfassen Checkliste erstellen</title>
    <link rel="stylesheet" href="/style_master.css">
    <link rel="stylesheet" href="/script/jquery.dataTables.min.css">
  </head>
  <body>
    <h1>Checkliste erstellen</h1>
    <h3>Wählen Sie, für welchen User eine neue Checkliste angelegt werden soll</h3>

    <script src="/script/jquery-3.5.1.js" charset="utf-8"></script>
    <script src="/script/dataTables.min.js" charset="utf-8"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#userlist').DataTable({
        "scrollX": true,
        "autoWidth": false
      });
      function reportWindowSize() {
        $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
      }

      window.onresize = reportWindowSize;
    } );
    </script>

    <a class="button" href="/db/index.php">Zurück zum Menu</a>
    <hr>

    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";
    $sql = "SELECT u.name, u.surname, u.shorty, u.number, u.workstart, u.telintern, u.telmobile, u.IdUser FROM createuser AS u LEFT JOIN createcheck as c on u.idUser = c.fkIdUser WHERE NULLIF(c.fkIdUser, '') IS NULL ORDER BY u.idUser DESC";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          // Getting Data
          //echo "Getting data with query: " . $sql;
          $userlist = mysqli_query($conn, $sql);
    }

    ?> <br>
    <div class="tablecontainer">
      <table id="userlist">
        <thead>
          <th>Name</th>
          <th>Nachname</th>
          <th>Kürzel</th>
          <th>Prs. Nr.</th>
          <th>Startdatum</th>
          <th>Tel. Intern</th>
          <th>Tel. Mobil</th>
        </thead>
        <tbody>
        <?php while($entry = mysqli_fetch_array($userlist)):; ?>
          <tr onclick="window.location='/db/addcheck/create/select.php?id=<?php echo $entry[7] ?>';">
            <td><?php echo $entry[0] ?></td>
            <td><?php echo $entry[1] ?></td>
            <td><?php echo $entry[2] ?></td>
            <td><?php echo $entry[3] ?></td>
            <td><?php echo $entry[4] ?></td>
            <td><?php echo $entry[5] ?></td>
            <td><?php echo $entry[6] ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <hr>
  </body>
</html>
