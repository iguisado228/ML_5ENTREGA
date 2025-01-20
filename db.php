<?php

function konexioaSortu()
{
    $servername = "localhost";
    $username = "root";
    $password = "1MG2024";
    $dbname = "markatzelengoaiak";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        error_log("DB konexio errorea: " . $conn->connect_error);
        die("Errorea datu-basearekin konektatzerakoan.");
    }

    $conn->set_charset("utf8");

    return $conn;
}
?>
