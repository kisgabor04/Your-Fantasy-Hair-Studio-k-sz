<?php
session_start();

$conn = new mysqli("localhost", "root", "", "users");

if ($conn->connect_error) {
    die("Sikertelen adatbázis-kapcsolat!" . $conn->connect_error);
}

$errorCode = 1;
$dataLine = [];
$stmt = $conn->prepare("SELECT datum, ido,szolgaltatas FROM idopontok WHERE fullname=? ORDER BY `idopontok`.`datum`, `idopontok`.`ido` ASC;");
$stmt->bind_param("s", $_SESSION["fullname"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
    while ($row = $result->fetch_assoc())
    {
        $dataLine[] = $row;
    }
    $errorCode = 0;
}
else
{
    $errorCode = 1;

}

$message = ["errorCode" => $errorCode, "date" => $dataLine];
echo json_encode($message);
?>
