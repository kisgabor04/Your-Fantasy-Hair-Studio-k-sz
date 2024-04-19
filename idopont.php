<?php
session_start();
$raw_datas = file_get_contents("php://input");
$datas = json_decode($raw_datas, true);

//Adatok kinyerése
if ($datas !== null) {
    $datum = $datas["datum"];
    $ido = $datas["ido"];
    $szolgaltatas = $datas["szolgaltatas"];
} else {
    $datum = $_POST["datum"];
    $ido = $_POST["ido"];
    $szolgaltatas = $_POST["szolgaltatas"];
}

$errorCode = 1;
$errorMessage ="Sikertelen időpontfoglalás!";
$dataLine = [];

$conn = new mysqli("localhost", "root", "","users");

if($conn -> connect_error)
{
    die("Probléma van az adatbáziscsatlakozással".$conn->connect_error);
}





$stmt = $conn->prepare("INSERT INTO idopontok(fullname,datum,ido,szolgaltatas) VALUES (?,?,?,?)");
$stmt ->bind_param("ssss",$_SESSION["fullname"],$datum,$ido, $szolgaltatas);
if($stmt->execute())
{
    $errorCode = 0;
    $errorMessage = "Sikeres időpontfoglalás!";
}
else
{
    $errorCode =1;
    $errorMessage ="Sikertelen időpontfoglalás! ".$stmt->error;
}
$stmt->close();
$conn->close();
$message = ["errorCode"=>$errorCode, "errorMessage" => $errorMessage];
echo json_encode($message);
?>