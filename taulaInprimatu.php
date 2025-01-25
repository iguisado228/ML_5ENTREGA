<?php
require_once("db.php");

if ($_GET["akzioa"] == "taulaInprimatu") {
    $conn = konexioaSortu();

    $sql = "SELECT Id, Postua, Dortsala, Izena FROM ml_5entrega order by Postua asc";
    $result = $conn->query($sql);
    $pilotoak = [];

    if ($result->num_rows > 0) {    
        $zenbatzailea = 0;
        while ($row = $result->fetch_assoc()) {
            $pilotoak[$zenbatzailea] = ["Id" => $row["Id"],"Postua" => $row["Postua"], "Dortsala" => $row["Dortsala"], "Izena" => $row["Izena"]];
            $zenbatzailea ++;
        }
        $pilotoak["kopurua"] = $zenbatzailea;
        
    } else {
        $pilotoak["kopurua"] = 0;
    }

    $bueltatutakoInfo = json_encode($pilotoak);
    echo $bueltatutakoInfo;
    die;
   
   
}
?>