<?php
$errorCode = 1;
$errorMessage = "";
$foglalt = [];

// Csatlakozás az adatbázishoz
$conn = new mysqli("localhost", "root", "", "users");
if ($conn->connect_error) {
    $errorCode = 1;
    $errorMessage = "Sikertelen adatbázis-kapcsolódás";
} else {
    $errorCode = 0;
    $errorMessage = "Sikeres csatlakozás az adatbázishoz!";

    // Lekérdezés előkészítése
    $stmt = $conn->prepare("SELECT * FROM idopontok;");
    $stmt->execute();

    // Eredmények eltárolása
    $result = $stmt->get_result();

    // Minden sor feldolgozása és hozzáadása a $foglalt tömbhöz
    while ($row = $result->fetch_assoc()) {
        $foglalt[] = ["datum" => $row["datum"], "ido" => $row["ido"]];
    }
}

// Válasz JSON formátumban
$response = ["errorCode" => $errorCode, "errorMessage" => $errorMessage, "foglalt" => $foglalt];
header('Content-Type: application/json');
echo json_encode($response);
?>
