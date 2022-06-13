<?php session_start();

if ($_SESSION['logged_in'] != true) {
  //header('Location: ' . "/index.php", true, 301);
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
    <link rel="stylesheet" href="/db/user/create/style_form.css">
    <title>User Erfassen</title>
  </head>
  <body>
    <h1>User erfassen / bearbeiten</h1>

    <?php
    if (isset($_SESSION["uid"])) {
      unset($_SESSION["uid"]);
    }

    if (isset($_SESSION["sendmail"])) {
      unset($_SESSION["sendmail"]);
    }

    if ($_SESSION["user_level"] <= 6) {
      $_SESSION["sendmail"] = 1;
    }

    if (isset($_GET["mail"])) {
      $_SESSION["sendmail"] = $_GET["mail"];
    }

    if (isset($_GET["id"])) {
      $_SESSION["uid"] = $_GET["id"];

      $servername = "localhost";
      $username = "userlister";
      $db = "userlist";
      $sql = "SELECT shorty, name, surname, number, workfunction, example, location, workstart, needswinuser, winexample, winextra, needsmailuser, email, mailgroups, needssap, sapprinter, needscrm, needsfsm, needstelintern, telintern, needstelmobile, telmobile, newhardware, oldhardwarename, oldhardwareserial, comment, sappassword, employment FROM createuser WHERE idUser = '" . $_GET["id"] . "'";

      // Create connection
      $conn = new mysqli($servername, $username, "", $db);

      // Check connection
      if ($conn->connect_error) {
        die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
      } else {
            // Getting Data
            $data = mysqli_fetch_array(mysqli_query($conn, $sql));
      }
    } else {
      $_SESSION["edit"] = "new";
    }
    ?>
    <br><div class="content"><span><a class="button menu_button" href="/db/index.php">Zurück zum Menu</a><p id="leavenotice">Änderungen gehen verloren!</p></span></div><br>
    <form class="form" id="createuser" action="/db/user/create/send.php" method="post">
      <h3>Identifikation</h3>
      <div class="cell4">
        <div class='input_field'><input type="text" name="name" placeholder="Vorname" maxlength="40" required <?php if (isset($data)) { echo "value='" . $data[1] . "'"; } ?>><label>Vorname</label></input></div>
        <div class='input_field'><input type="text" name="surname" placeholder="Nachname" maxlength="40" required <?php if (isset($data)) { echo "value='" . $data[2] . "'"; } ?>><label>Nachname</label></input></div>
        <div class='input_field'><input type="number" name="number" placeholder="Personalnummer" required <?php if (isset($data)) { echo "value='" . $data[3] . "'"; } ?>><label>Personalnummer</label></input> <br></div>
        <div class='input_field'><input type="text" name="shorty" placeholder="Kürzel (EDV)" maxlength="45" <?php if (isset($data)) { echo "value='" . $data[0] . "'"; } ?>><label>Kürzel</label></input></div>
      </div>

      <hr>
      <h3>Details</h3>
      <div class="cell4">
        <div class='input_field'><input type="text" name="function" placeholder="Funktion" maxlength="80" required <?php if (isset($data)) { echo "value='" . $data[4] . "'"; } ?>><label>Funktion</label></input></div>
        <div class='input_field'><input type="text" name="example" placeholder="Vorbild" maxlength="45" required <?php if (isset($data)) { echo "value='" . $data[5] . "'"; } ?>><label>Vorbild</label></input></div>
        <div class='input_field'><input type="text" name="location" placeholder="Standort" maxlength="25" required <?php if (isset($data)) { echo "value='" . $data[6] . "'"; } ?>><label>Standort</label></input></div>
        <div class='input_field'><input type="date" name="start" required <?php if (isset($data)) { echo "value='" . $data[7] . "'"; } ?>><label>Startdatum</label></input></div>
        <div class='input_field'><input type="text" name="employment" placeholder="Beschäftigungsgrad" maxlength="50" required <?php if (isset($data)) { echo "value='" . $data[27] . "'"; } ?>><label>Beschäftigungsgrad</label></input></div>
      </div>

      <hr>
      <h3>Windows User</h3>
      <p>Benötigt Windows User</p>
      <input type="checkbox" name="winuser" id="winusercheck" onclick="Winuser();" <?php if (isset($data)) { if ($data[8] == "on") { echo "checked"; } } ?>> <br>

      <div class="cell225">
        <div class='input_field'><input id="winpermexample" type="text" name="winpermexample" placeholder="Vorbild" maxlength="45" required <?php if (isset($data)) { echo "value='" . $data[9] . "'"; } ?>><label>Vorbild</label></input></div>
        <div class='input_field'><label>Spezielle Berechtigungen</label><textarea id="winpermextra" name="winpermspecial" rows="3" cols="35" ><?php if (isset($data)) { echo $data[10]; } ?></textarea></div>

      </div>

      <hr>
      <h3>Mail User</h3>
      <p>Benötigt Mail </p> <input type="checkbox" name="mailuser" id="mailusercheck" onclick="Mailuser();" <?php if (isset($data)) { if ($data[11] == "on") { echo "checked"; } } ?>> <br>
      <div class="cell225">
        <div class='input_field'><input id="mailaddress" type="text" name="mailaddress" placeholder="E-Mail Adresse" maxlength="60" required size="35" <?php if (isset($data)) { echo "value='" . $data[12] . "'"; } ?>><label>E-Mail Adresse</label></input></div>
        <div class="input_field"><label>Mailgruppen</label><textarea id="mailgroups" name="mailgroups" rows="3" cols="35"><?php if (isset($data)) { echo $data[13]; } ?></textarea></div>
      </div>

      <hr>
      <h3>SAP User</h3>
      <p>Benötigt SAP: </p> <input id="sapusercheck" type="checkbox" name="sapuser" onclick="SAPuser();" <?php if (isset($data)) { if ($data[14] == "on") { echo "checked"; } } ?>> <br>
      <div class="cell2">
        <div class='input_field'><input id="sapprinter" type="text" name="sapprinter" placeholder="SAP Drucker" maxlength="25" required <?php if (isset($data)) { echo "value='" . $data[15] . "'"; } ?>><label>SAP Drucker</label></input></div>
        <div class='input_field'><input id="sappassword" type="text" name="sappassword" placeholder="SAP Passwort" maxlength="70" <?php if (isset($data)) { echo "value='" . $data[26] . "'"; } ?>><label>SAP Passwort</label></input></div>
      </div>

      <hr>
      <h3>Andere User</h3>
      <div class="cell4">
        <div class="input_field"><p>Benötigt CRM: <input type="checkbox" name="crmuser" <?php if (isset($data)) { if ($data[16] == "on") { echo "checked"; } } ?>></p></div>
        <div class="input_field"><p>Benötigt FSM: <input type="checkbox" name="fsmuser" <?php if (isset($data)) { if ($data[17] == "on") { echo "checked"; } } ?>></p></div>
      </div>

      <hr>
      <h3>Telefonie</h3>
      <div class="cell2">
        <div class='input_field'><p>Telefon Intern: <input id="telintern" type="checkbox" name="telintern" onclick="Telintern();" <?php if (isset($data)) { if ($data[18] == "on") { echo "checked"; } } ?>></p></div>
        <div class='input_field'><p>Telefon Mobil: <input id="telmobile" type="checkbox" name="telmobile" onclick="Telmobile();" <?php if (isset($data)) { if ($data[20] == "on") { echo "checked"; } } ?>></p></div>
        <div class='input_field'><input id="telinternnumber" type="number" name="telinternnumber" placeholder="Tel intern" maxlength="35" <?php if (isset($data)) { echo "value='" . $data[19] . "'"; } ?>><label>Tel intern</label></input></div>
        <div class='input_field'><input id="telmobilenumber" type="number" name="telmobilenumber" placeholder="Tel mobil" maxlength="35" required <?php if (isset($data)) { echo "value='" . $data[21] . "'"; } ?>><label>Tel mobil</label></input></div>
      </div>

      <hr>
      <h3>Hardware</h3>
      <p>Neue Hardware muss bestellt werden: </p> <input id="hardwarenew" type="checkbox" name="hardwarenew" onclick="Hardwarenew();" <?php if (isset($data)) { if ($data[22] == "on") { echo "checked"; } } ?>> <br>
      <div class="cell2">
        <div class='input_field'><input id="oldhardwarename" type="text" name="oldhardwarename" placeholder="Übernimmt HW von" maxlength="40" required <?php if (isset($data)) { echo "value='" . $data[23] . "'"; } ?>><label>Übernimmt HW von</label></input></div>
        <div class='input_field'><input id="oldhardwarenumber" type="text" name="oldhardwarenumber" placeholder="Seriennummer der HW" maxlength="50" <?php if (isset($data)) { echo "value='" . $data[24] . "'"; } ?>><label>Seriennummer der HW</label></input></div>
      </div>

      <hr>
      <h3>Bemerkungen</h3>
      <div class="cell1">
        <div class="input_field"><label>Kommentar</label><textarea name="comments" rows="5" cols="50"><?php if (isset($data)) { echo $data[25]; } ?></textarea></div>
      </div>
      <hr>

      <h3>History</h3>
      <div class="history">
        <table>
          <tr>
            <th>Datum</th>
            <th>Name</th>
            <th>Username</th>
            <th>Kommentar</th>
          </tr>
            <?php
            $historyRaw = mysqli_query($conn, "SELECT name, surname, username, moddate, comment FROM history WHERE idEntry = '" . $_GET["id"] . "'");
            while($history = mysqli_fetch_array($historyRaw)):; ?>
              <tr>
                <td><?php echo $history[3] ?></td>
                <td><?php echo $history[0] . " " . $history[1] ?></td>
                <td><?php echo $history[2] ?></td>
                <td><?php echo $history[4] ?></td>
              </tr>
            <?php endwhile;?>
        </table>
      </div>
      <hr>

      <input type="hidden" name="historyName" value="<?php echo $_SESSION["user_name"] ?>">
      <input type="hidden" name="historyUsername" value="<?php echo $_SESSION["adminuser"] ?>">
      <input type="hidden" name="historyModdate" value="<?php echo date("Y-m-d") ?>">

      <input type="hidden" name="sendA" value="create">
      <div class="cell225">
        <input class="button" type="submit" value="Bestätigen">
        <div class="input_field"><input type="text" name="historyComment" placeholder="Änderungskommentar"></div>
      </div>
    </form>


    <script type="text/javascript">

      //initially en- or disable fields according to set data
      <?php if (isset($data)) { if ($data[8] != "on") { echo "document.getElementById('winpermextra').disabled = true;"; echo "document.getElementById('winpermexample').disabled = true;"; } } else { echo "document.getElementById('winpermextra').disabled = true;"; echo "document.getElementById('winpermexample').disabled = true;"; } ?>
      <?php if (isset($data)) { if ($data[11] != "on") { echo "document.getElementById('mailaddress').disabled = true;"; echo "document.getElementById('mailgroups').disabled = true;"; } } else { echo "document.getElementById('mailaddress').disabled = true;"; echo "document.getElementById('mailgroups').disabled = true;"; } ?>
      <?php if (isset($data)) { if ($data[14] != "on") { echo "document.getElementById('sapprinter').disabled = true;"; echo "document.getElementById('sappassword').disabled = true;"; } } else { echo "document.getElementById('sapprinter').disabled = true;"; echo "document.getElementById('sappassword').disabled = true;"; } ?>
      <?php if (isset($data)) { if ($data[18] != "on") { echo "document.getElementById('telinternnumber').disabled = true;"; } } else { echo "document.getElementById('telinternnumber').disabled = true;"; } ?>
      <?php if (isset($data)) { if ($data[20] != "on") { echo "document.getElementById('telmobilenumber').disabled = true;"; } } else { echo "document.getElementById('telmobilenumber').disabled = true;"; } ?>
      <?php if (isset($data)) { if ($data[22] == "on") { echo "document.getElementById('oldhardwarename').disabled = true;"; echo "document.getElementById('oldhardwarenumber').disabled = true;"; } } else { echo "document.getElementById('oldhardwarename').disabled = false;"; echo "document.getElementById('oldhardwarenumber').disabled = false;"; } ?>

      //checkbox triggered functions
      function Winuser()
      {
        if (document.getElementById('winusercheck').checked)
        {
          document.getElementById("winpermextra").disabled = false;
          document.getElementById("winpermexample").disabled = false;
        } else {
          document.getElementById("winpermextra").disabled = true;
          document.getElementById("winpermexample").disabled = true;
          document.getElementById("winpermextra").value = "";
          document.getElementById("winpermexample").value = "";
        }
        }

        function Mailuser()
        {
          if (document.getElementById('mailusercheck').checked) {
            document.getElementById("mailaddress").disabled = false;
            document.getElementById("mailgroups").disabled = false;
          } else {
            document.getElementById("mailaddress").disabled = true;
            document.getElementById("mailgroups").disabled = true;
            document.getElementById("mailaddress").value = "";
            document.getElementById("mailgroups").value = "";
          }
        }

        function SAPuser() {
          if (document.getElementById('sapusercheck').checked) {
            document.getElementById("sapprinter").disabled = false;
            document.getElementById("sappassword").disabled = false;
          } else {
            document.getElementById("sapprinter").disabled = true;
            document.getElementById("sapprinter").value = "";
            document.getElementById("sappassword").disabled = true;
            document.getElementById("sappassword").value = "";
          }
        }

        function Telintern() {
          if (document.getElementById('telintern').checked) {
            document.getElementById("telinternnumber").disabled = false;
          } else {
            document.getElementById("telinternnumber").disabled = true;
            document.getElementById("telinternnumber").value = "";
          }
        }

        function Telmobile() {
          if (document.getElementById('telmobile').checked) {
            document.getElementById("telmobilenumber").disabled = false;
          } else {
            document.getElementById("telmobilenumber").disabled = true;
            document.getElementById("telmobilenumber").value = "";
          }
        }

        function Hardwarenew() {
          if (document.getElementById('hardwarenew').checked) {
            document.getElementById("oldhardwarename").disabled = true;
            document.getElementById("oldhardwarenumber").disabled = true;
            document.getElementById("oldhardwarename").value = "";
            document.getElementById("oldhardwarenumber").value = "";
          } else {
            document.getElementById("oldhardwarename").disabled = false;
            document.getElementById("oldhardwarenumber").disabled = false;
          }
        }
    </script>
  </body>
</html>
