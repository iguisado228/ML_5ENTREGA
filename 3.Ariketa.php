<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.Ariketa</title>
</head>

<body>

    <!-- Formulario bat eskualdeak aukeratzeko-->
    <form action="3.Ariketa.php" method="POST">
        <label for="eskualdea">Eskualdeak</label>
        <!-- onchange-ak egiten du aldaketa bat gertatzean formularioan, herriakEguneratu() funtzioa abiaraziko duela-->
        <select id="eskualdea" name="eskualdea" onchange="herriakEguneratu()">
            <option value=""></option>
            <option value="Goierri">
                Goierri
            </option>
            <option value="Urola">
                Urola
            </option>
            <option value="Buruntzaldea">
                Buruntzaldea
            </option>
        </select>
        <!-- Herriak aukeratzeko formularioa-->
        <label for="herriak">Herriak</label>
        <select id="herriak" name="herriak"></select>
    </form>

    <!-- jquery erabili ahal izateko link-a-->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>

        //behin orrialdea kargatzen denean, herriakEguneratu() funtzioa 1 segundoan behin exekutatuko da
        $(document).ready(function () {
            setInterval (herriakEguneratu, 1000);
        });

            //herriakEguneratu() funtzioa formularioan aukeratutako eskualdearen arabera herriak aukeratzeko
            function herriakEguneratu() {
                $.ajax({
                "url": "3.Ariketa.php",
                "method": "POST",
                "data": {
                    "akzioa": "herriakEguneratu",

                }
            })

            //array bat sortu eskualdeak eta herriak gordetzeko
            const herriak = [
                { eskualdea: 'Goierri', herriak: ['Beasain', 'Ordizia', 'Zumarraga'] },
                { eskualdea: 'Urola', herriak: ['Zestoa', 'Azpeitia', 'Azkoitia'] },
                { eskualdea: 'Buruntzaldea', herriak: ['Andoain', 'Urnieta', 'Lasarte-Oria']}
            ];

                //eskualdearen arabera herriak aukeratzeko
                const eskualdea = document.getElementById('eskualdea').value; //eskualdea aukeratzeko
                const herriaSelect = document.getElementById('herriak'); //herriak aukeratzeko
                herriaSelect.innerHTML = ''; //eskualdez aldatzerakoan, herriak ezabatzeko eta horrela beste herriak agertzeko
               
            
                if (eskualdea) {
                    const eskualdekoHerria = herriak.find(h => h.eskualdea === eskualdea); //eskualdean barnean dauden herriak aukeratzeko
                    eskualdekoHerria.herriak.forEach(herriak => { //eskualde bakoitzeko dauden herriak banaka agertzeko, hauetatik aukeratu dezazun
                        const option = document.createElement('option'); //option elementua sortu herrien arteko aukeraketa egiteko
                        option.value = herriak;
                        option.text = herriak;
                        herriaSelect.append(option); //.append() funtzioa erabili aukeratutako herriak formularioan agertzeko bata bestearen azpian
                    });
                }
            }

    </script>
</body>

</html>