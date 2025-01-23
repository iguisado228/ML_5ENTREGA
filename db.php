<?php

function konexioaSortu()
{
    $servername = "localhost";
    $username = "root";
    $password = "1MG2024";
    $dbname = "markatzelengoaiak";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Konexioan hurrengo errorea gertatu da: " . $conn->connect_error);
    }

    return $conn;
}
?>
