<?php session_start();
error_reporting(E_ERROR | E_PARSE); //don't show infos like unset variables
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

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

if (isset($_POST["sendA"]) && $_POST["sendA"] == "create")  {
  unset($_POST["sendA"]);
} else {
  die("Nichts zu senden / Wurde bereits gesendet.");
}
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User anlegen</title>
    <link rel="stylesheet" href="/style_master.css">
  </head>
  <body>
    <h1>User wird angelegt...</h1>
    <?php
    //require("/usr/share/php/libphp-phpmailer/autoload.php"); //include mail function

    if (isset($_SESSION["uid"])) {
      $sql = "UPDATE createuser SET shorty = '" . $_POST["shorty"] . "', name = '" . $_POST["name"] . "', surname = '" . $_POST["surname"] . "', number = '" . $_POST["number"] . "', workfunction = '" . $_POST["function"] . "', example = '" . $_POST["example"] . "', location = '" . $_POST["location"] . "', workstart = '" . $_POST["start"] . "', needswinuser = '" . $_POST["winuser"] . "', winexample = '" . $_POST["winpermexample"] . "', winextra = '" . $_POST["winpermspecial"] . "', needsmailuser = '" . $_POST["mailuser"] . "', email = '" . $_POST["mailaddress"] . "', mailgroups = '" . $_POST["mailgroups"] . "', needssap = '" . $_POST["sapuser"] . "', sapprinter = '" . $_POST["sapprinter"] . "', needscrm = '" . $_POST["crmuser"] . "', needsfsm = '" . $_POST["fsmuser"] . "', needstelintern = '" . $_POST["telintern"] . "', telintern = '" . $_POST["telinternnumber"] . "', needstelmobile = '" . $_POST["telmobile"] . "', telmobile = '" . $_POST["telmobilenumber"] . "', newhardware = '" . $_POST["hardwarenew"] . "', oldhardwarename = '" . $_POST["oldhardwarename"] . "', oldhardwareserial = '" . $_POST["oldhardwarenumber"] . "', comment = '" . $_POST["comments"] . "', sappassword = '" . $_POST["sappassword"] . "', employment = '" . $_POST["employment"] . "' WHERE idUser = '" . $_SESSION["uid"] . "'";
      unset($_SESSION["uid"]);
    } else {
      $sql = "INSERT INTO createuser (shorty, name, surname, number, workfunction, example, location, workstart, needswinuser, winexample, winextra, needsmailuser, email, mailgroups, needssap, sapprinter, needscrm, needsfsm, needstelintern, telintern, needstelmobile, telmobile, newhardware, oldhardwarename, oldhardwareserial, comment, sappassword, employment) VALUES ('" . $_POST["shorty"] . "', '" . $_POST["name"] . "', '" . $_POST["surname"] . "', '" . $_POST["number"] . "', '" . $_POST["function"] . "', '" . $_POST["example"] . "', '" . $_POST["location"] . "', '" . $_POST["start"] . "', '" . $_POST["winuser"] . "', '" . $_POST["winpermexample"] . "', '" . $_POST["winpermspecial"] . "', '" . $_POST["mailuser"] . "', '" . $_POST["mailaddress"] . "', '" . $_POST["mailgroups"] . "', '" . $_POST["sapuser"] . "', '" . $_POST["sapprinter"] . "', '" . $_POST["crmuser"] . "', '" . $_POST["fsmuser"] . "', '" . $_POST["telintern"] . "', '" . $_POST["telinternnumber"] . "', '" . $_POST["telmobile"] . "', '" . $_POST["telmobilenumber"] . "', '" . $_POST["hardwarenew"] . "', '" . $_POST["oldhardwarename"] . "', '" . $_POST["oldhardwarenumber"] . "', '" . $_POST["comments"] . "', '" . $_POST["sappassword"] . "')";
    }

    $sqlget = "SELECT idUser, name, surname FROM createuser WHERE shorty = '" . $_POST["shorty"] . "' AND name = '" . $_POST["name"] . "' AND surname = '" . $_POST["surname"] . "' AND number = '" . $_POST["number"] . "' AND workfunction = '" . $_POST["function"] . "' AND example = '" . $_POST["example"] . "' AND location = '" . $_POST["location"] . "' AND workstart = '" . $_POST["start"] . "' AND needswinuser = '" . $_POST["winuser"] . "' AND winexample = '" . $_POST["winpermexample"] . "' AND winextra = '" . $_POST["winpermspecial"] . "' AND needsmailuser = '" . $_POST["mailuser"] . "' AND email = '" . $_POST["mailaddress"] . "' AND mailgroups = '" . $_POST["mailgroups"] . "' AND needssap = '" . $_POST["sapuser"] . "' AND sapprinter = '" . $_POST["sapprinter"] . "' AND needscrm = '" . $_POST["crmuser"] . "' AND needsfsm = '" . $_POST["fsmuser"] . "' AND needstelintern = '" . $_POST["telintern"] . "' AND telintern = '" . $_POST["telinternnumber"] . "' AND needstelmobile = '" . $_POST["telmobile"] . "' AND telmobile = '" . $_POST["telmobilenumber"] . "' AND newhardware = '" . $_POST["hardwarenew"] . "' AND oldhardwarename = '" . $_POST["oldhardwarename"] . "' AND oldhardwareserial = '" . $_POST["oldhardwarenumber"] . "' AND comment = '" . $_POST["comments"] . "' AND sappassword = '" . $_POST["sappassword"] . "';";


    $servername = "localhost";
    $username = "userlister";
    $db = "userlist";

    // Create connection
    $conn = new mysqli($servername, $username, "", $db);

    // Check connection
    if ($conn->connect_error) {
      die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
    } else {
          //setting data
          if ($conn->query($sql) === TRUE) {
            echo "Der User-Eintrag für " . $_POST["name"] . " " . $_POST["surname"] . " wurde erfolgreich angelegt / editiert.";
          //getting date from created entry
          $userinfo = mysqli_fetch_array(mysqli_query($conn, $sqlget)); //if php error with bool, it means the SQL-Query failed!

          //write to history
          $sqlhistory = "INSERT INTO history (name, username, moddate, comment, typeEntry, idEntry) VALUES ('" . $_POST["historyName"] . "', '" . $_POST["historyUsername"] . "', '" . $_POST["historyModdate"] . "', '" . $_POST["historyComment"] . "', '1',  '" . $userinfo[0] . "')";
          if ($conn->query($sqlhistory) != TRUE) {
            echo "<p>Eintrag History konnte nicht bearbeitet werden!</p>";
          }

            //send mail if needed
            if (isset($_SESSION["sendmail"]) && $_SESSION["sendmail"] == 1){
              unset($_SESSION["sendmail"]);
              //get hyperlink url for mail
              if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $url = "https://";
              else
                $url = "http://";
                // Append the host(domain name, ip) to the URL.
                $url.= $_SERVER['HTTP_HOST'];

              //create the maio
              $mail = new PHPMailer\PHPMailer\PHPMailer();
              $mail->CharSet = 'UTF-8';

              $mail->isSMTP();
              $mail->Host = "172.20.128.1";
              $mail->Port = 25;

              $mail->From = "useradmin@duscholux.ch";
              $mail->FromName = "Useradmin";

              $sqlemail = "SELECT email FROM maillist WHERE mailgroup = '1'";
              $emails = mysqli_query($conn, $sqlemail);
              if (isset($emails) && $emails != "") {
                while($maio = mysqli_fetch_array($emails)) {
                  $mail->addAddress($maio[0]);
                }

                $message = "
                <!DOCTYPE html>
                <html lang='de' dir='ltr'>
                  <head>
                    <meta charset='utf-8'>
                    <title>Neuer User</title>
                    <style media='screen'>
                      p, h1, h2, h3, h4, a {
                        font-family: sans-serif;
                      }
                      a {
                        text-decoration: none;
                        color: #000;
                        padding: 3px;
                        border-width: 1px;
                        border-style: solid;
                        background-color: #FFF;
                        border-radius: 0px;
                        transition: 0.5s;
                      }
                      a:hover {
                        background-color: #AAF;
                        border-radius: 6px;
                      }
                      body {
                        max-width: 600px;
                        margin: auto;
                        margin-top: 50px;
                        background-color: #DFE;
                      }
                    </style>
                  </head>
                  <body>
                    <h1>Useradministration</h1>
                    <h3>Neuer User wurde beantragt.</h3>
                    <p>Guten Tag.<br><br>Es wurde das erfassen eines neuen Users beantragt.<br>Bitte ergänzen Sie wenn nötig Informationen und erstellen Sie eine Checkliste zum erstellen des neuen Users.</p>
                    <a href='" . $url . "/db/user/create/index.php?id=" . $userinfo[0] . "'>Informationen ergänzen</a>
                    <a href='" . $url . "/db/addcheck/create/select.php?id=" . $userinfo[0] . "'>Checkliste erstellen</a>
                    <p>Freundliche Grüsse<br>Das Useradministrations-Team</p>
                  </body>
                </html>
                ";

                $mail->isHTML(true);

                $mail->Subject = "Neuer User '" . $userinfo[1] . " " . $userinfo[2] . "'";
                $mail->Body = $message;

                try {
                  $mail->send();
                  echo"<p>Der Eintrag wurde an die IT weitergeleitet.<br>Vielen Dank für Ihre Zeit.</p>";
                  echo "<a class='button' href='/db/settings/logout.php'>Ausloggen</a>";
                  echo "<a class='button' href='/db/index.php'>Zurück zum Menu</a>";
                  die();
                } catch (Exception $e) {
                  echo"<p>E-Mail konnte nicht an die IT weitergeleitet werden!<br>Bitte melden Sie diesen Fehler bei der EDV. Vielen Dank!</p>";
                  echo "<a class='button' href='/db/index.php'>Zurück zum Menu</a>";
                }

              } else {
                echo "<p>Es wurden keine Emails für die IT Abteilung angegeben!</p>";
                echo "<a class='button' href='/db/index.php'>Zurück zum Menu</a>";
                die();
              }
            }

          } else {
            echo "Beim beim Eintragen des Users ist ein Fehler aufgetreten!";
            die (" Query: " . $sql . " ERROR: " . mysqli_error($conn));
          }
          echo "<p>User erstellt / bearbeitet, weiterleitung zum menu...</p>";
          echo "<script> location.href='/db/index.php'; </script>";
    }
     ?>
  </body>
</html>
