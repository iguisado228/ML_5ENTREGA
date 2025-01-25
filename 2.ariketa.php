<?php
require_once("db.php");
$conn = konexioaSortu();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Id']) && isset($_POST['Postua'])) {
    $Id = $_POST['Id'];
    $PostuBerria = $_POST['Postua'];

    $sql = "UPDATE ml_5entrega SET Postua = '$PostuBerria' WHERE Id = '$Id'";

    if ($conn->query($sql) === TRUE) {
        echo "success"; 
    } else {
        echo "error: " . $conn->error;
    }
    exit;
}



$sql = "SELECT Id, Postua, Dortsala, Izena FROM ml_5entrega order by Postua asc";
$result = $conn->query($sql);

echo "<h3>Pilotoen zerrenda:</h3>";
if ($result->num_rows > 0) {
    echo "<table border='1' class='taula'>";
    echo "<tr><th>Id</th><th>Postua</th><th>Dortsala</th><th>Izena</th></tr>";
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function () {
            // $(".taulaBirkargatu").on("click", function () {
            //     taulaBirkargatu();
            // });
            setInterval(taulaBirkargatu, 1000);
        });

       
    $("#PostuaEguneratu").submit(function (e) {
        e.preventDefault(); 

        let formData = $(this).serialize(); 
        console.log("Enviando datos:", formData); 

        $.ajax({
            url: "2.ariketa.php",
            type: "POST",
            data: formData,
            success: function (response) {
                console.log("Respuesta del servidor:", response); 
                if (response.trim() === "success") {
                    alert("Postua eguneratua!");
                    taulaBirkargatu(); 
                } else {
                    alert("Errorea eguneratzean: " + response); 
                }
            },
            error: function () {
                alert("Errorea zerbitzariarekin konektatzean.");
            }
        });
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
                        $(".taula").html("<th>Id</th><th>Postua</th><th>Dortsala</th><th>Izena</th>");
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
    <form id="PostuaEguneratu">
    <label for="Id">Sartu pilotoaren Id-a:</label>
    <input type="text" name="Id" required><br><br>

    <label for="Postua">Sartu pilotoaren postu berria:</label>
    <input type="text" name="Postua" required><br><br>

    <button type="submit">Eguneratu</button>
</form>


</body>

</html>