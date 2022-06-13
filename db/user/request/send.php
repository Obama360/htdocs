<?php session_start();
error_reporting(E_ERROR | E_PARSE);

if (isset($_POST["sendA"]) && $_POST["sendA"] == "request")  {
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
    $sql = "INSERT INTO createuser (number, name, surname, workfunction, example, location, workstart, needswinuser, winexample, winextra, needsmailuser, email, mailgroups, needssap, sapprinter, needscrm, needsfsm, needstelintern, telintern, needstelmobile, telmobile, newhardware, oldhardwarename, oldhardwareserial, comment) VALUES (NULL,'" . $_POST["name"] . "', '" . $_POST["surname"] . "', '" . $_POST["function"] . "', '" . $_POST["example"] . "', '" . $_POST["location"] . "', '" . $_POST["start"] . "', '" . $_POST["winuser"] . "', '" . $_POST["winpermexample"] . "', '" . $_POST["winpermspecial"] . "', '" . $_POST["mailuser"] . "', '" . $_POST["mailaddress"] . "', '" . $_POST["mailgroups"] . "', '" . $_POST["sapuser"] . "', '" . $_POST["sapprinter"] . "', '" . $_POST["crmuser"] . "', '" . $_POST["fsmuser"] . "', '" . $_POST["telintern"] . "', '" . $_POST["telinternnumber"] . "', '" . $_POST["telmobile"] . "', '" . $_POST["telmobilenumber"] . "', '" . $_POST["hardwarenew"] . "', '" . $_POST["oldhardwarename"] . "', '" . $_POST["oldhardwarenumber"] . "', '" . $_POST["comments"] . "')";

    $sqlget = "SELECT idUser, name, surname FROM createuser WHERE name = '" . $_POST["name"] . "' AND surname = '" . $_POST["surname"] . "' AND workfunction = '" . $_POST["function"] . "' AND example = '" . $_POST["example"] . "' AND location = '" . $_POST["location"] . "' AND workstart = '" . $_POST["start"] . "' AND needswinuser = '" . $_POST["winuser"] . "' AND winexample = '" . $_POST["winpermexample"] . "' AND winextra = '" . $_POST["winpermspecial"] . "' AND needsmailuser = '" . $_POST["mailuser"] . "' AND email = '" . $_POST["mailaddress"] . "' AND mailgroups = '" . $_POST["mailgroups"] . "' AND needssap = '" . $_POST["sapuser"] . "' AND sapprinter = '" . $_POST["sapprinter"] . "' AND needscrm = '" . $_POST["crmuser"] . "' AND needsfsm = '" . $_POST["fsmuser"] . "' AND needstelintern = '" . $_POST["telintern"] . "' AND telintern = '" . $_POST["telinternnumber"] . "' AND needstelmobile = '" . $_POST["telmobile"] . "' AND telmobile = '" . $_POST["telmobilenumber"] . "' AND newhardware = '" . $_POST["hardwarenew"] . "' AND oldhardwarename = '" . $_POST["oldhardwarename"] . "' AND oldhardwareserial = '" . $_POST["oldhardwarenumber"] . "' AND comment = '" . $_POST["comments"] . "';";

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
            //get uid and name of created user entry for mail
            //echo $sqlget;
            $userinfo = mysqli_fetch_array(mysqli_query($conn, $sqlget)); //if php error with bool, it means the SQL-Query failed! (activate above command and run directy in sql server to get info)

            //write into history table
            $sqlhistory = "INSERT INTO history (name, surname, username, moddate, typeEntry, idEntry, comment) VALUES ('" . $_SESSION["historyName"] . "', '" . $_SESSION["historySurname"] . "', '" . $_SESSION["historyUsername"] . "', '" . date("Y-m-d") . "', '1', '" . $userinfo[0] . "', 'Original request')";
            if ($conn->query($sqlhistory) != TRUE) {
              echo "Der History konnte nicht angelegt werden!";
            }

            //get hyperlink url for mail
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
              $url = "https://";
            else
              $url = "http://";
              // Append the host(domain name, ip) to the URL.
              $url.= $_SERVER['HTTP_HOST'];

              // Append desired location
              $url.= "/db/user/create/index.php?id=";

              //create the maio
              /*$mail = new PHPMailer\PHPMailer\PHPMailer();
              $mail->CharSet = 'UTF-8';

              $mail->isSMTP();
              $mail->Host = "172.20.128.1";
              $mail->Port = 25;

              $mail->From = "useradmin@duscholux.ch";
              $mail->FromName = "Useradmin";

              // get email addresses
              $sqlemail = "SELECT email FROM maillist WHERE mailgroup = '0'";
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
                <p>Guten Tag.<br><br>Es wurde das erfassen eines neuen Users von einem Mitarbeiter beantragt.<br>Bitte teilen Sie dem beantragten User eine Personalnummer zu.</p>
                <a href='" . $url . $userinfo[0] . "&mail=1'>Zum Eintrag</a>
                <p>Freundliche Grüsse<br>Das Useradministrations-Team</p>
              </body>
            </html>
            ";

            $mail->isHTML(true);

            $mail->Subject = "Neuer User '" . $userinfo[1] . " " . $userinfo[2] . "' wurde beantragt";
            $mail->Body = $message;
            */

            try {
              //$mail->send();
              echo"<p>Der Eintrag wurde ans HR weitergeleitet.<br>Vielen Dank für Ihre Zeit.<br><br>Die Seite kann nun geschlossen werden.</p>";
              die();
            } catch (Exception $e) {
              echo"<p>E-Mail konnte nicht ans HR weitergeleitet werden!<br>Bitte melden Sie diesen Fehler bei der EDV. Vielen Dank!</p>";
              die();
            }
          } else {
            echo "Es wurden keine E-Mail Adressen angegeben für die HR Abteilung!";
          }
          /*} else {
            echo "Beim beim Eintragen des Users ist ein Fehler aufgetreten!";
            die (" Query: " . $sql . " ERROR: " . mysqli_error($conn));
          }*/
    }

     ?>
  </body>
</html>
