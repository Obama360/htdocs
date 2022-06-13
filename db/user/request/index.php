<?php
session_start();
if (isset($_POST["historyName"]) && $_POST["historyName"] != "") {
  $_SESSION["historyName"] = $_POST["historyName"];
  $_SESSION["historySurname"] = $_POST["historySurname"];
  $_SESSION["historyUsername"] = $_POST["historyUsername"];
} else {
  echo "<script> location.href='/db/user/request/getuserinfo.php?url=/db/user/request/index.php'; </script>";
}
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/db/user/create/style_form.css">
    <title>User Erfassen beantragen</title>
  </head>
  <body>
    <h1>User erfassung beantragen</h1>

    <form class="form" id="createuser" action="/db/user/request/send.php" method="post">
      <h3>Identifikation</h3>
      <div class="cell4">
        <div class='input_field'><input type="text" name="name" placeholder="Vorname" maxlength="40" required><label>Vorname</label></input></div>
        <div class='input_field'><input type="text" name="surname" placeholder="Nachname" maxlength="40" required><label>Nachname</label></input></div>
        <div class='input_field'><input type="text" name="shorty" placeholder="Kürzel (EDV)" maxlength="45"><label>Kürzel</label></input></div>
      </div>

      <hr>
      <h3>Details</h3>
      <div class="cell4">
        <div class='input_field'><input type="text" name="function" placeholder="Funktion" maxlength="80" required><label>Funktion</label></input></div>
        <div class='input_field'><input type="text" name="example" placeholder="Vorbild" maxlength="45" required><label>Vorbild</label></input></div>
        <div class='input_field'><input type="text" name="location" placeholder="Standort" maxlength="25" required><label>Standort</label></input></div>
        <div class='input_field'><input type="date" name="start" required><label>Startdatum</label></input></div>
      </div>

      <hr>
      <h3>Windows User</h3>
      <p>Benötigt Windows User</p>
      <input type="checkbox" name="winuser" id="winusercheck" onclick="Winuser();" <?php if (isset($data)) { if ($data[8] == "on") { echo "checked"; } } ?>> <br>

      <div class="cell225">
        <div class='input_field'><input id="winpermexample" type="text" name="winpermexample" placeholder="Vorbild" maxlength="45" required><label>Vorbild</label></input></div>
        <div class='input_field'><label>Spezielle Berechtigungen</label><textarea id="winpermextra" name="winpermspecial" rows="3" cols="35" ></textarea></div>

      </div>

      <hr>
      <h3>Mail User</h3>
      <p>Benötigt Mail </p> <input type="checkbox" name="mailuser" id="mailusercheck" onclick="Mailuser();"> <br>
      <div class="cell225">
        <div class='input_field'><input id="mailaddress" type="text" name="mailaddress" placeholder="E-Mail Adresse" maxlength="60" required size="35"><label>E-Mail Adresse</label></input></div>
        <div class="input_field"><label>Mailgruppen</label><textarea id="mailgroups" name="mailgroups" rows="3" cols="35"></textarea></div>
      </div>

      <hr>
      <h3>SAP User</h3>
      <p>Benötigt SAP: </p> <input id="sapusercheck" type="checkbox" name="sapuser" onclick="SAPuser();"> <br>
      <div class="cell2">
        <div class='input_field'><input id="sapprinter" type="text" name="sapprinter" placeholder="SAP Drucker" maxlength="25" required><label>SAP Drucker</label></input></div>
        <div class='input_field'><input id="sappassword" type="text" name="sappassword" placeholder="SAP Passwort" maxlength="70"><label>SAP Passwort</label></input></div>
      </div>

      <hr>
      <h3>Andere User</h3>
      <div class="cell4">
        <div class="input_field"><p>Benötigt CRM: <input type="checkbox" name="crmuser"></p></div>
        <div class="input_field"><p>Benötigt FSM: <input type="checkbox" name="fsmuser"></p></div>
      </div>

      <hr>
      <h3>Telefonie</h3>
      <div class="cell2">
        <div class='input_field'><p>Telefon Intern: <input id="telintern" type="checkbox" name="telintern" onclick="Telintern();"></p></div>
        <div class='input_field'><p>Telefon Mobil: <input id="telmobile" type="checkbox" name="telmobile" onclick="Telmobile();"></p></div>
        <div class='input_field'><input id="telinternnumber" type="number" name="telinternnumber" placeholder="Tel intern" maxlength="35"><label>Tel intern</label></input></div>
        <div class='input_field'><input id="telmobilenumber" type="number" name="telmobilenumber" placeholder="Tel mobil" maxlength="35" required><label>Tel mobil</label></input></div>
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
      <input type="hidden" name="sendA" value="request">
      <input class="submit_button" type="submit" value="Bestätigen">
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
