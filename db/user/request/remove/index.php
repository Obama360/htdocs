<?php session_start();?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User erfassen Checkliste öffnen</title>
    <link rel="stylesheet" href="/style_master.css">
    <link rel="stylesheet" href="/script/jquery.dataTables.min.css">
  </head>
  <body>
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

    <h1>User Auswählen</h1>
    <h3>Wählen Sie den User, für welchen Sie eine Löschung beantragen möchten</h3>

    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";
    $sql = "SELECT u.name, u.surname, u.shorty, u.number, u.workstart, u.telintern, u.telmobile FROM createuser AS u";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          // Getting Data
          //echo "Getting data with query: " . $sql;
          $userlist = mysqli_query($conn, $sql) OR die("Ein Fehler ist aufgetreten beim abfragen der Daten. Query: " . $sql);
    }

    ?>
    <a class="button" href="/portal.php">Zurück zum Portal</a>
        <hr>
    <br>

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
          <tr onclick="window.location='/db/user/request/remove/confirm.php?id=<?php echo $entry[7] ?>';">
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
      <hr>
      <h4>Der gewünschte User ist nicht in der Liste?</h4>
      <div class="invisiblecontainer"><a class="button centerbutton" href="/db/user/request/remove/request.php">User manuell angeben</a></div>
    </div>
    <hr>
  </body>
</html>
