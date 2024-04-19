<?php
session_start();

//Van-e bejelentkezett felhasználói munkamenet
if (!isset($_SESSION["username"])) {
    // Ha nincs bejelentkezett felhasználó
    $response = ["user" => "Felhasználó nem található!"];
    echo json_encode($response);
    exit;
}

if (isset($_SESSION["username"]))
{
    //Ha van bejelentkezett felhasználó
    $response = ["user"=>$_SESSION["username"], "hairdresser"=>$_SESSION["hairdresser"]];
    echo json_encode($response);
    exit;
}


?>