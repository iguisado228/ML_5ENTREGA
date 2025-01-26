<?php
require_once("db.php"); //datu baseekin konexioa sortzeko funtzioak dauden fitxategia deitzeko
$conn = konexioaSortu(); //konexioa sortzen du


 //post bidez datuak bidaltzen dira eta Id eta Postua datuak daude
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Id']) && isset($_POST['Postua'])) {
    $Id = $_POST['Id'];
    $PostuBerria = $_POST['Postua'];


    //datu baseetan updatea egin ahal izateko sql kontsulta
    $sql = "UPDATE ml_5entrega SET Postua = '$PostuBerria' WHERE Id = '$Id'"; 

    //sql kontsulta exekutatzen da, exekuzioa ondo joaten bada "success" mezua agertuko du
    if ($conn->query($sql) === TRUE) { 
        echo "success"; 
    } else {
        echo "error: " . $conn->error;
    }
    exit;
}


//datu baseetako informazioa taulan inprimatzeko sql kontsulta
$sql = "SELECT Id, Postua, Dortsala, Izena FROM ml_5entrega order by Postua asc";
$result = $conn->query($sql);

echo "<h3>Pilotoen zerrenda:</h3>";

//taula inprimatzen da
if ($result->num_rows > 0) {
    echo "<table border='1' class='taula'>";
    echo "<tr><th>Id</th><th>Postua</th><th>Dortsala</th><th>Izena</th></tr>";

    //datu basetako linea bakoitzaren arabera informazioa agertzen du
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Id"] . "</td>";
        echo "<td>" . $row["Postua"] . "</td>";
        echo "<td>" . $row["Dortsala"] . "</td>";
        echo "<td>" . $row["Izena"] . " </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Ez dago daturik taulan.";
}
//konexioa ixten du
$conn->close();
?>
<br>
<button class="taulaBirkargatu">Birgarkatu</button>

<!DOCTYPE html>
<html>

<head>
    <title>2.ariketa</title>
</head>

<body>

<!-- jquery erabili ahal izateko link-a-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        //taula birkargatzeko funtzioa
        //documentua kargatzen denean funtzioa egingo du
        $(document).ready(function () {
            // $(".taulaBirkargatu").on("click", function () {
            //     taulaBirkargatu();
            // });
            //honek interbalo bat neurtzen du, sartzen diogun denboraren arabera, kasu honetan taulaBirkargatu funtzioa segunduro exekutatuko du.
            setInterval(taulaBirkargatu, 1000);
        });

       
    //postua eguneratzeko funtzioa function(e)-k egiten duena da botoia sakatzean ez dela orrialdea berriz kargatzen
    $("#PostuaEguneratu").submit(function (e) {
        e.preventDefault(); 

        //datuak bidaltzeko formularioko datuak hartzen ditu
        let formData = $(this).serialize(); 
        //datuak konsolan agertzen dira
        console.log("Enviando datos:", formData); 

        //ajax deitzen da, datuak bidaltzeko eta jasotzeko, honetarako URL bat, tipoa eta data beharko dira
        $.ajax({
            url: "2.ariketa.php",
            type: "POST",
            data: formData,

            //ondo joan bada "success" mezua agertuko da eta taula birkargatuko da
            success: function (response) {
                console.log("Respuesta del servidor:", response); 
                if (response.trim() === "success") {
                    alert("Postua eguneratua!");
                    taulaBirkargatu(); 
                } else {
                    alert("Errorea eguneratzean: " + response); 
                }
            },
            //errore bat egon bada "error" mezua agertuko da
            error: function () {
                alert("Errorea zerbitzariarekin konektatzean.");
            }
        });
    });


        //taula birkargatzeko funtzioa
        function taulaBirkargatu() {
            //ajax deitzen da, datuak bidaltzeko eta jasotzeko, honetarako URL bat, metodoa eta data beharko dira berriro
            $.ajax({
                "url": "taulaInprimatu.php",
                "method": "GET",
                "data": {
                    "akzioa": "taulaInprimatu",
                }
            })
                
                //behin funtzioa exekutatzen denean, datuak jasotzen dira eta taula berriz kargatzen da
                .done(function (bueltatutakoInfo) {

                    //jasotako datuak JSON formatuan daude, beraz parse egin behar da
                    var datuak = JSON.parse(bueltatutakoInfo);
                    //jasotako datu kopurua 0 bada, alert bat agertuko da
                    if (datuak.kopurua > 0) {
                        $(".taula").html("");
                        $(".taula").html("<th>Id</th><th>Postua</th><th>Dortsala</th><th>Izena</th>");
                        //for bat datuak taula moduan agertzeko lineaka, .append erabilita bata bestearen azpitik agertuko dira.
                        for (var i = 0; i < datuak.kopurua; i++) {
                            $(".taula").append(
                                "<tr>" +
                                "<td>" + datuak[i].Id + "</td>" +
                                "<td>" + datuak[i].Postua + "</td>" +
                                "<td>" + datuak[i].Dortsala + "</td>" +
                                "<td>" + datuak[i].Izena + "</td>" +
                                "</tr>"
                            );
                        }
                    } else {
                        alert("Ez da elementurik kargatu");
                    }
                })
                .fail(function () {
                    alert("gaizki joan da");
                })

        }

    </script>

    <!-- Formulario bat non pilotoaren Id-a eskatzen duena eta harek izango duen postua agertzen duena-->
    <form id="PostuaEguneratu">
    <label for="Id">Sartu pilotoaren Id-a:</label>
    <input type="text" name="Id" required><br><br>

    <label for="Postua">Sartu pilotoaren postu berria:</label>
    <input type="text" name="Postua" required><br><br>

    <button type="submit">Eguneratu</button>
</form>


</body>

</html>