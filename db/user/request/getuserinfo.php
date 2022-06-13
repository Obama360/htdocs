<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style_master.css">
    <title>Ihre angaben</title>
  </head>
  <body>
    <h1>Identifikation</h1>
    <h4>Bitte geben Sie Ihre Personalien an, damit wir bei Fragen auf Sie zukommen können.<br>Vielen Dank.</h4>

    <form class="form" id="createuser" action="<?php echo $_GET["url"] ?>" method="post">
      <div class="invisiblecontainer grid2">
        <p>Vorname</p> <input type="text" name="historyName" maxlength="25" required></input>
        <p>Nachname</p> <input type="text" name="historySurname" maxlength="25" required></input>
        <p>Personalnummer</p> <input type="text" name="historyUsername" maxlength="30" required></input>
        <input class="submit_button" type="submit" value="Bestätigen">
      </div>
    </form>

  </body>
</html>
