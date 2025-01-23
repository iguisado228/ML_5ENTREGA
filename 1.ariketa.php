<?php
require_once("db.php");

$conn = konexioaSortu();

$sql = "SELECT Postua, Dortsala, Izena FROM ml_5entrega order by Postua asc";
$result = $conn->query($sql);

echo "<h3>Pilotoen zerrenda:</h3>";
if ($result->num_rows > 0) {
    echo "<table border='1' class='taula'>";
    echo "<tr><th>Postua</th><th>Dortsala</th><th>Izena</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Postua"] . "</td>";
        echo "<td>" . $row["Dortsala"] . "</td>";
        echo "<td>" . $row["Izena"] . " </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Ez dago daturik taulan.";
}
$conn->close();
?>
<br>
<button class="taulaBirkargatu">Birgarkatu</button>

<!DOCTYPE html>
<html>

<head>
    <title>1.ariketa</title>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script>
        $(document).ready(function () {
            // $(".taulaBirkargatu").on("click", function () {
            //     taulaBirkargatu();
            // });
            setInterval(taulaBirkargatu, 1000);
        });

        function taulaBirkargatu() {

            $.ajax({
                "url": "taulaInprimatu.php",
                "method": "GET",
                "data": {
                    "akzioa": "taulaInprimatu",
                }
            })

                .done(function (bueltatutakoInfo) {

                    var datuak = JSON.parse(bueltatutakoInfo);
                    if (datuak.kopurua > 0) {
                        $(".taula").html("");
                        $(".taula").html("<th>Postua</th><th>Dortsala</th><th>Izena</th>");
                        for (var i = 0; i < datuak.kopurua; i++) {
                            $(".taula").append(
                                "<tr>" +
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

</body>

</html>