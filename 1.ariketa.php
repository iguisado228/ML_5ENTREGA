<?php
//datu baseetako fitxategiari deitzen dio 
require_once("db.php");

//konexioa sortzen du datu baseekin
$conn = konexioaSortu();

//sql kontsulta bat egiten du datuak erakusteko eta postua ordenean jartzen du
$sql = "SELECT Postua, Dortsala, Izena FROM ml_5entrega order by Postua asc";
$result = $conn->query($sql);

//taularen izenburua inprimatzen du
echo "<h3>Pilotoen zerrenda:</h3>";
//kontsultaren erantzunean lerroak dauden begiratzen du eta lerro guztiak inprimatzeaz zihurtatzen da
if ($result->num_rows > 0) {
    //taularen estiloa eta zutabeen izenburuak inprimatzen ditu
    echo "<table border='1' class='taula'>";
    echo "<tr><th>Postua</th><th>Dortsala</th><th>Izena</th></tr>";
    //lerroak dauden bitartean lerroak inprimatzen ditu datu baseetatik hartutako informazioarekin
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Postua"] . "</td>";
        echo "<td>" . $row["Dortsala"] . "</td>";
        echo "<td>" . $row["Izena"] . " </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    //taulan daturik ez badago mezu bat inprimatzen du
    echo "Ez dago daturik taulan.";
}
//datu baseekin konexioa isten du
$conn->close();
?>
<br>
<!-- taula manualki inprimatzeko botoia -->
<button class="taulaBirkargatu">Birgarkatu</button>

<!DOCTYPE html>
<html>

<head>
    <title>1.ariketa</title>
</head>

<body>
    <!-- jquery liburutegia inportatu eta kargatzen du -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script>
        $(document).ready(function () {
            // $(".taulaBirkargatu").on("click", function () {
            //     taulaBirkargatu();
            // });
            //taulaBirkargatu funtzioa segunduro exekutatzen du taula birkargatzeko
            setInterval(taulaBirkargatu, 1000);
        });

        //taula birkargatzeko funtzioa sortzen da
        function taulaBirkargatu() {
            // PHP fitxategiaren URLa definitzen du eskaera prozesatzeko
            $.ajax({
                "url": "taulaInprimatu.php",
                "method": "GET",
                "data": {
                    "akzioa": "taulaInprimatu",
                }
            })
                //informazioa bueltatzen duen funtzioa sortzen du
                .done(function (bueltatutakoInfo) {
                    //JSON formatuko datuak javascript eko datuetan gordetzen ditu
                    var datuak = JSON.parse(bueltatutakoInfo);
                    //datu guztiak inprimatzeaz zihurtatzen da
                    if (datuak.kopurua > 0) {
                        //taula hustu egiten du
                        $(".taula").html("");
                        //taularen izenburuak inprimatzen ditu
                        $(".taula").html("<th>Postua</th><th>Dortsala</th><th>Izena</th>");
                        //datuak hartzen ditu eta inprimatu egiten ditu lerroetan, for buklea erabiliz datu guztiak inprimatzen ditu
                        for (var i = 0; i < datuak.kopurua; i++) {
                            //append erabiltzen da, datu bakoitza bestearen azpian inprimatzeko
                            $(".taula").append(
                                "<tr>" +
                                "<td>" + datuak[i].Postua + "</td>" +
                                "<td>" + datuak[i].Dortsala + "</td>" +
                                "<td>" + datuak[i].Izena + "</td>" +
                                "</tr>"
                            );
                        }
                        //daturik ez badago mezu bat inprimatzen du
                    } else {
                        alert("Ez da elementurik kargatu");
                    }
                    //errore bat egon bada mezu bat inprimatzen du
                })
                .fail(function () {
                    alert("gaizki joan da");
                })

        }

    </script>

</body>

</html>