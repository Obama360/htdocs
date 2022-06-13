<?php session_start();
error_reporting(E_ERROR | E_PARSE); //don't show infos like unset variables

if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progess...");
} else {
  $_SESSION['logged_in'] = true;
  if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] < 10) {
    echo "<a href='/index.php'>Mit anderem User anmelden</a> <br>";
    die("Der angemeldete user hat kein Zugriffsrecht auf diese Seite.");
  }
}
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin User auswählen</title>
    <link rel="stylesheet" href="/style_master.css">
    <link rel="stylesheet" href="/script/jquery.dataTables.min.css">
  </head>
  <body>
    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";
    $sql = "SELECT idAdminUser, username, name FROM adminusers WHERE level < 10 ORDER BY idAdminUser DESC";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          // Getting Data
          $adminusers = mysqli_query($conn, $sql);
    }

    ?>
    <h1>Admin User anpassen</h1>

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

    <h3>Wählen Sie einen Admin User zum anpassen aus</h3> <hr>
    <a class="button" href="/db/index.php">Zurück zum Menu</a> <hr>
    <div class="tablecontainer">
      <table id="userlist">
        <thead>
          <th>Username</th>
          <th>Name</th>
        </thead>
        <tbody>
        <?php while($entry = mysqli_fetch_array($adminusers)):; ?>
          <tr onclick="window.location='/db/settings/admin/user/edit/edit.php?id=<?php echo $entry[0] ?>';">
            <td><?php echo $entry[1] ?></td>
            <td><?php echo $entry[2] ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <hr>
  </body>
</html>
