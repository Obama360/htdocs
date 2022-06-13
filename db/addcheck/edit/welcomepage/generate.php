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

//getting info for welcome PDF
if (isset($_SESSION["welcomeinfo"])) {
  $info = $_SESSION["welcomeinfo"];
  //unset($_SESSION["welcomeinfo"]); activate if needed
} else {
  echo "<p>Es wurden keine Informationen für das Willkommensblatt angegeben!</p>";
  echo "<a href='/db/index.php'>Zurück zum Menu</a>";
  die();
}

// Optionally define the filesystem path to your system fonts
// otherwise tFPDF will use [path to tFPDF]/font/unifont/ directory
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");

require("tfpdf.php");

//create pdf
$pdf = new tFPDF();

//set title and add a page
$pdf->SetTitle("Willkommensblatt", true); //true because utf8 (false = ISO-8859-1)
$pdf->AddPage();

//Set Unicode font (uses UTF-8)
define("_SYSTEM_TTFONTS", "/var/www/html/db/addcheck/edit/welcomepage/font/");
$pdf->AddFont("Arial","","Arial Unicode MS.ttf",true);


//Header design
$pdf->SetFillColor(184, 216, 230);
$pdf->Rect(0,13,210,21,"F");
$pdf->Image("logo.png",69,17,70);
$pdf->SetFillColor(159, 192, 207);
$pdf->Rect(0,32.8,210,50.5,"F");
$pdf->Image("banner.png",65,33,80);
$pdf->SetFillColor(184, 216, 230);
$pdf->Rect(0,83,210,21,"F");
$pdf->SetFont("Arial","",26);
$pdf->SetXY(20, 88);
$pdf->Write(5,"Herzlich Willkommen bei der Duscholux!");
$pdf->SetFont("Arial","",11);
$pdf->SetXY(27, 96);
$pdf->Write(5,"Wir wünschen Ihnen einen erfolgreichen Start und freuen uns auf die Zusammenarbeit.");

//Body design
$pdf->SetXY(18, 115);
$pdf->SetFont("Arial","",12);
$pdf->Write(5,"Auf diesem Dokument finden Sie Ihre Zugangsdaten für die Systeme der Duscholux:");

//set positions
$x1 = 18;
$x2 = 90;
$y = 133;

//number
$pdf->SetXY($x1, $y);
$pdf->Write(5,"Ihre Benutzer/Personalnummer:");
$pdf->SetXY($x2, $y);
$pdf->Write(5,$info[0]);
$y += 10;

//shorty
$pdf->SetXY($x1, $y);
$pdf->Write(5,"Ihr Kurzzeichen:");
$pdf->SetXY($x2, $y);
$pdf->Write(5,$info[1]);
$y += 10;

//email
if ($info[2] == "on") {
  $pdf->SetXY($x1, $y);
  $pdf->Write(5,"Ihre E-Mail Adresse:");
  $pdf->SetXY($x2, $y);
  $pdf->Write(5,$info[3]);
  $y += 10;
}

//phone
if ($info[4] != "" || $info[5] != "") {
  $pdf->SetXY($x1, $y);
  $pdf->Write(5,"Ihre Telefonnummer:");
  $pdf->SetXY($x2, $y);
  $pdf->Write(5,$info[4] . $info[5]);
  $y += 10;
}

//password win
if ($info[6] == "on" && isset($_POST["passwordwin"])) {
  $pdf->SetXY($x1, $y);
  $pdf->Write(5,"Windows Kennwort:");
  $pdf->SetXY($x2, $y);
  $pdf->Write(5,$_POST["passwordwin"]);
  $y += 10;
}

//password notes
if ($info[2] == "on" && isset($_POST["passwordnotes"])) {
  $pdf->SetXY($x1, $y);
  $pdf->Write(5,"Notes Kennwort:");
  $pdf->SetXY($x2, $y);
  $pdf->Write(5,$_POST["passwordnotes"]);
  $y += 10;
}

//password SAP
if ($info[7] == "on" && isset($_POST["passwordsap"])) {
  $pdf->SetXY($x1, $y);
  $pdf->Write(5,"SAP Kennwort:");
  $pdf->SetXY($x2, $y);
  $pdf->Write(5,$_POST["passwordsap"]);
  $y += 10;
}

//password TimeTool
if (isset($_POST["passwordtimetool"])) {
  $pdf->SetXY($x1, $y);
  $pdf->Write(5,"TimeTool Kennwort:");
  $pdf->SetXY($x2, $y);
  $pdf->Write(5,$_POST["passwordtimetool"]);
  $y += 10;
}

//PIN Mobile
if (isset($_POST["passwordsimmobile"]) && $_POST["passwordsimmobile"] != "") {
  $pdf->SetXY($x1, $y);
  $pdf->Write(5,"PIN SIM-Mobile:");
  $pdf->SetXY($x2, $y);
  $pdf->Write(5,$_POST["passwordsimmobile"]);
  $y += 10;
}

//PIN Data
if (isset($_POST["passwordsimdata"]) && $_POST["passwordsimdata"] != "") {
  $pdf->SetXY($x1, $y);
  $pdf->Write(5,"PIN SIM-Data:");
  $pdf->SetXY($x2, $y);
  $pdf->Write(5,$_POST["passwordsimdata"]);
  $y += 10;
}

//Footer design
$pdf->SetXY(18, 235);
$pdf->SetFont("Arial","",10);
$pdf->Write(5,"Unter dem Folgenden Pfad finden Sie die internen Richtlinien sowie Schulungsunterlagen im Bereich IT.");
$pdf->SetXY(18, 245);
$pdf->Write(5,"Wenn Laufwerk F:\\ Vorhanden: ");
$pdf->SetTextColor(0, 0, 238);
$pdf->Write(5,"F:\\International_Austauschlaufwerk\\Dokumentationen IT");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(18, 250);
$pdf->Write(5,"Wenn Laufwerk F:\\ nicht vorhanden: ");
$pdf->SetTextColor(0, 0, 238);
$pdf->Write(5,"\\\\fileserver\\Int_Share\\Dokumentationen IT");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(18, 260);
$pdf->Write(5,"Wir bitten Sie, diese durchzulesen. Bei Fragen stehen wir gerne zur Verfügung!");
$pdf->SetXY(18, 270);
$pdf->SetFont("Arial","",11);
$pdf->Write(5,"Ihr IT Team            033 33 44 444");


//Render the PDF
$pdf->Output();
?>
