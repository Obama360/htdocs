<?php session_start();
if ($_SESSION['logged_in'] != true) {
  echo "<script> location.href='/index.php'; </script>";
  die("redirect in progess...");
} else {
  $_SESSION['logged_in'] = true;
}
 ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta charset="utf-8">
    <title>Useradmin Menu</title>
    <link rel="stylesheet" href="/style_master.css">
  </head>
  <body>


    <div class="headermenu">
      <button id="headerbutton" type="button" name="button">Verlassen</button>
      <div class="headermenu_content">

        <a href="/db/settings/admin/changepassword.php">
        <div>
          <img src='/db/ressources/icon_settings/button_settings_password.png' alt='Passwort ändern'>
          <p>Passwort ändern</p>
        </div>
        </a>

        <a href="/db/settings/logout.php">
        <div>
          <img src='/db/ressources/icon_settings/button_settings_logout.png' alt='Logout'>
          <p>Logout</p>
        </div>
        </a>
      </div>
    </div>

    <div class="scene">
      <img id="logo" src="/images/logo_static.png" alt="Useradministration Logo">
    </div>

    <h1>Useradministration</h1>

    <h4>Eingeloggt als: <?php echo $_SESSION["user_name"] . " (" . $_SESSION["adminuser"] . ")"?></h4>
    <hr>

    <?php
    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";

    $sqlacreate = "SELECT COUNT(finishdate) FROM createcheck WHERE NULLIF(finishdate, '') IS NULL";
    $sqladelete = "SELECT COUNT(finishdate) FROM deletecheck WHERE NULLIF(finishdate, '') IS NULL";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Get data
    $acreate = mysqli_fetch_array(mysqli_query($conn, $sqlacreate));
    $adelete = mysqli_fetch_array(mysqli_query($conn, $sqladelete));

    if ($_SESSION["user_level"] >= 3) {
      echo "<div class='menuchunk'>
      <img class='chunklogo' src='/db/ressources/icon_user/button_user_normal.png' alt='bababui'>
          <div class='menubar'>
          <h3>User erfassen / editieren</h3>
          <div class='menu'>
            <div class='menubutton'>";

            if ($_SESSION["user_level"] < 7) {
              echo "<a href='/db/user/create/index.php?mail=1'>";
            } else {
              echo "<a href='/db/user/create/index.php'>";
            }

            echo "<img src='/db/ressources/icon_user/button_user_add.png' alt='Neuen User erfassen'>
                <p>Neuen User erfassen</p>
              </a>
            </div>

            <div class='menubutton'>
              <a href='/db/user/edit/edit.php'>
                <img src='/db/ressources/icon_user/button_user_edit.png' alt='User editieren'>
                <p>User editieren</p>
              </a>
            </div>

            <div class='menubutton'>
              <a href='/db/user/remove/index.php'>
                <img src='/db/ressources/icon_user/button_user_remove.png' alt='User löschen'>
                <p>User löschen</p>
              </a>
            </div>
          </div>
          </div>
          </div>
          <hr>";
    } ?>

    <?php if ($_SESSION["user_level"] >= 7) {
      echo " <div class='menuchunk'>
          <img class='chunklogo' src='/db/ressources/icon_checklist_add/button_checklist_normal.png' alt='bababui'>
          <div class='menubar'>

          <h3>Erfassen Checkliste</h3>
          <div class='menu'>
            <div class='menubutton'>
              <a href='/db/addcheck/create/index.php'>
                <img src='/db/ressources/icon_checklist_add/button_checklist_add.png' alt='Neuen User erfassen'>
                <p>Neue Liste</p>
              </a>
            </div>

            <div class='menubutton'>
              <a href='/db/addcheck/edit/index.php?filter=1'>
              <div class='buttoncontainer'>
                <img src='/db/ressources/icon_checklist_add/button_checklist_open.png' alt='User editieren'>";
              if (isset($acreate[0]) && $acreate[0] > 0) {
                echo "<p class='notification'>" . $acreate[0] . "</p>";
              }
              echo "</div>
                <p>Offene Listen</p>
              </a>
            </div>

            <div class='menubutton'>
              <a href='/db/addcheck/edit/index.php?filter=2'>
                <img src='/db/ressources/icon_checklist_add/button_checklist_done.png' alt='User löschen'>
                <p>Fertige Listen</p>
              </a>
            </div>
          </div>
          </div>
          </div>
          <hr>";
    } ?>

    <?php if ($_SESSION["user_level"] >= 7) {
      echo "<div class='menuchunk'>
          <img class='chunklogo' src='/db/ressources/icon_checklist_remove/button_checklist_normal.png' alt='bababui'>
          <div class='menubar'>

          <h3>Löschen Checkliste</h3>
          <div class='menu'>
            <div class='menubutton'>
              <a href='/db/deletecheck/create/index.php'>
                <img src='/db/ressources/icon_checklist_remove/button_checklist_add.png' alt='Neuen Liste erfassen'>
                <p>Neue Liste</p>
              </a>
            </div>

            <div class='menubutton'>
              <a href='/db/deletecheck/edit/index.php?filter=1'>
	       <div class='buttoncontainer'>
                <img src='/db/ressources/icon_checklist_remove/button_checklist_open.png' alt='Offene Listen'>";
                if (isset($adelete[0]) && $adelete[0] > 0) {
                  echo "<p class='notification'>" . $adelete[0] . "</p>";
                }
		echo "</div>
                <p>Offene Listen</p>
              </a>
            </div>

            <div class='menubutton'>
              <a href='/db/deletecheck/edit/index.php?filter=2'>
                <img src='/db/ressources/icon_checklist_remove/button_checklist_done.png' alt='Abgeschlossene Listen'>
                <p>Fertige Listen</p>
              </a>
            </div>
          </div>
          </div>
          </div>
          <hr>";
    } ?>

    <?php if ($_SESSION["user_level"] >= 10) {
      echo "<div class='menuchunk'>
          <img class='chunklogo' src='/db/ressources/icon_admin/button_admin_normal.png' alt='bababui'>
          <div class='menubar'>

          <h3>Administration</h3>
          <div class='menu'>
            <div class='menubutton'>
              <a href='/db/settings/admin/email/change.php'>
                <img src='/db/ressources/icon_admin/button_admin_email.png' alt='E-Mail Listen bearbeiten'>
                <p>Email Listen</p>
              </a>
            </div>

            <div class='menubutton'>
                <a href='/db/settings/admin/user/edit/index.php'>
                  <img src='/db/ressources/icon_admin/button_admin_edit.png' alt='Admin bearbeiten'>
                  <p>Admin bearbeiten</p>
                </a>
              </div>

              <div class='menubutton'>
                <a href='/db/settings/admin/user/create/index.php'>
                  <img src='/db/ressources/icon_admin/button_admin_create.png' alt='Admin erstellen'>
                  <p>Admin erstellen</p>
                </a>
              </div>
              </div>
              </div>";
            }

        echo "</div>
          <hr>"; ?>

  </body>
</html>
