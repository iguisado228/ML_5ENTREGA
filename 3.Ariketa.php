<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.Ariketa</title>
</head>

<body>
    <form action="3.Ariketa.php" method="POST">
        <label for="eskualdea">Eskualdeak</label>
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
        <label for="herriak">Herriak</label>
        <select id="herriak" name="herriak"></select>
    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function () {
            setInterval (herriakEguneratu, 1000);
        });
            function herriakEguneratu() {
                $.ajax({
                "url": "3.Ariketa.php",
                "method": "POST",
                "data": {
                    "akzioa": "herriakEguneratu",

                }
            })

            const herriak = [
                { eskualdea: 'Goierri', herriak: ['Beasain', 'Ordizia', 'Zumarraga'] },
                { eskualdea: 'Urola', herriak: ['Zestoa', 'Azpeitia', 'Azkoitia'] },
                { eskualdea: 'Buruntzaldea', herriak: ['Andoain', 'Urnieta', 'Lasarte-Oria']}
            ];
                const eskualdea = document.getElementById('eskualdea').value;
                const herriaSelect = document.getElementById('herriak');
                herriaSelect.innerHTML = '';
               

                if (eskualdea) {
                    const eskualdekoHerria = herriak.find(h => h.eskualdea === eskualdea);
                    eskualdekoHerria.herriak.forEach(herriak => {
                        const option = document.createElement('option');
                        option.value = herriak;
                        option.text = herriak;
                        herriaSelect.append(option);
                    });
                }
            }

    </script>
</body>

</html>