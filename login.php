<?php
    session_start();
    $raw_datas = file_get_contents("php://input");
    $datas = json_decode($raw_datas, true);
    
    $errorCode = 1;
    $errorMessage ="Sikertelen bejelentkezés!";
    $dataLine =[];

    //Adatok kinyerése
    if ($datas !==null)
    {
        $username = $datas["username"];
        $password = $datas["password"];
    }
    else 
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
    }
    

    

    //Csatlakozás az adatbázishoz:

    $conn = new mysqli("localhost", "root","","users");
    if($conn->connect_error)
    {
        $errorCode = 1;
        $errorMessage = "Sikertelen csatlakozás az adatbázishoz!";
        die("Sikertelen csatlakozás az adatbázishoz!". $conn->connect_error);
    }



    
    //Lekérdezés előkészítés
    $stmt = $conn->prepare("SELECT * FROM datas WHERE username = ?;");
    $stmt->bind_param("s",$username);

    //Elküldés:
    $stmt->execute();

    $result = $stmt->get_result();

    if($row =$result->fetch_assoc())
    {
        if($username===$row["username"])
        {
            //Helyes-e a jelszó?
            if($password===$row["password"])
            {
                $_SESSION["username"] = $row["username"];
                $_SESSION["hairdresser"] = $row["hairdresser"];
                $_SESSION["fullname"] = $row["fullname"];
                $errorCode = 0;
                $errorMessage ="Sikeres bejelentkezés!";
                $dataLine = ["hairdresser"=>$row["hairdresser"],"fullname"=>$row["fullname"]];

            }
            else
            {
                $errorCode = 1;
                $errorMessage = "Hibás felhasználónév vagy jelszó!";
            }
        }
    }
    else
    {
        $errorCode =1;
        $errorMessage ="Hibás felhasználónév vagy jelszó!";
    }

    $message = ["errorCode"=>$errorCode, "errorMessage"=>$errorMessage, "dataLine"=>$dataLine];
    echo json_encode($message);
?>