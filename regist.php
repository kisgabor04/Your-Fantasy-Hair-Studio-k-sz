<?php
session_start();
$raw_datas = file_get_contents("php://input");
$datas = json_decode($raw_datas, true);

//Kinyerjük a beírt adatokat a POST-ból vagy a php inputból
if ($datas !== null) {
    $username = $datas["username"];
    $password = $datas["password"];
    $fullname = $datas["fullname"];
} else {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $fullname = $_POST["fullname"];
}
//Alapeset
$errorCode = 1;
$errorMessage = "Sikertelen regisztráció!";


$hairdresser = false;

$conn = new mysqli("localhost", "root", "", "users");

//Adatbáziskapcsolat ellenőrzése
if ($conn->connect_error) 
{
    $errorCode = 1;
    $errorMessage = "Sikertelen csatlakozás az adtbázishoz!";
    die ("Sikertelen kapcsolódás az adatbázishoz: " . $conn->connect_error);
}
//Lekérdezés előkészítése
$stmt = $conn->prepare("SELECT * FROM datas WHERE username = ?;");
$stmt->bind_param("s",$username);

//Lekérdezés elküldése
$stmt->execute();
//Lekérdezés eredmény kikérése
$result=$stmt->get_result();
//Ha kapunk a válaszban legalább egy sort akkor már foglalt a felhasználónév
if($result->num_rows > 0)
{
        $errorCode = 1;
        $errorMessage = "Ez a felhasználónév már foglalt!";
        
}else 
    {
    //Ha nincs még ilyen felhasználó akkor beleírjuk az adatbázisba
    $stmt = $conn->prepare("INSERT INTO datas(username,password, fullname, hairdresser) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $password, $fullname, $hairdresser);

    //Ha bele írjuk akkor sikeres, különben sikertelen
    if ($stmt->execute()) {
        $errorCode = 0;
        $errorMessage = "Sikeres regisztráció!";
        
    } else {
        $errorCode = 1;
        $errorMessage = "Sikertelen regisztráció!". $stmt->error;
        
    }
}
$stmt->close();
$conn->close();
//Válasz küldése a JS számára
$message = ["errorCode" => $errorCode, "errorMessage" => $errorMessage];
echo json_encode($message);
?>