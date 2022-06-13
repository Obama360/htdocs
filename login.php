<?php session_start();

if (isset($redirect)) {
  unset($redirect);
} else {
  if (isset($_SESSION["redirect"]) && $_SESSION["redirect"] != "") {
    if (strpos($_SESSION["redirect"], "portal.php") !== false) {
      $redirect = "/db/index.php";
    } else {
      $redirect = $_SESSION["redirect"];
    }
  }
}

$servername = "localhost";
$username = "userlister";
$db = "userlist";
$sqlget = "SELECT COUNT(username) FROM adminusers WHERE username = '" . $_POST["username"] . "' AND password = MD5('" . $_POST["password"] . "')";
$sqllogin = "SELECT username, level, name FROM adminusers WHERE username = '" . $_POST["username"] . "' AND password = MD5('" . $_POST["password"] . "')";

// Create connection
$conn = new mysqli($servername, $username, "", $db);

// Check connection
if ($conn->connect_error) {
  die("Es konnte keine Verbindung mit dem Datenbankserver aufgebaut werden!");
} else {
  // Getting data
  $answer = mysqli_fetch_array(mysqli_query($conn, $sqlget));
  if ($answer[0] == 1) {
    $logininfo = mysqli_fetch_array(mysqli_query($conn, $sqllogin));
    if (isset($logininfo) && $logininfo[0] == $_POST["username"]) {
      $_SESSION['logged_in'] = "true";
      $_SESSION['user_level'] = $logininfo[1];
      $_SESSION['adminuser'] = $logininfo[0];
      $_SESSION['user_name'] = $logininfo[2];

      if (isset($_SESSION["redirect"]) && $_SESSION["redirect"] != "") {
        unset($_SESSION["redirect"]);
        header('Location: ' . $redirect, true, 301);
      } else {
        header('Location: ' . "/db/index.php", true, 301);
      }
      die();
    }
  } elseif ($answer[0] > 1) {
    //multiple matches?
    die("Es wurden mehrere logins mit diesen credentials gefunden! Bitte Manuell beheben.");
  } else {
    $_SESSION['loginfailed'] = "true";
    if (isset($redirect) && $redirect != "") {
      header('Location: ' . $redirect, true, 301); //not elegant solution but this way it will redirect to requested url after succesfull login
    } else {
      header('Location: ' . "/index.php", true, 301);
    }
    die();
  }
}
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Vorgang</title>
  </head>
  <body>
    <h1>Login wird verarbeitet...</h1>
  </body>
</html>
