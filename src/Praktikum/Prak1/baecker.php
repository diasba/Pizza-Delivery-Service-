<?php
$html = <<<HTML
<!DOCTYPE html>
<html lang="de">  
<head>
    <meta charset="UTF-8">
    <title>Pizzabäcker-Seite</title>
</head>
<body>
    <header>
        <h1>Willkommen beim Pizzaservice, lieber Pizzabäcker!</h1>
        <nav>
            <ul>
                <li><a href="fahrer.php">Fahrer</a></li>
                <li><a href="bestellungen.php">Bestellungen</a></li>
                <li><a href="kunde.php">Kunde</a></li>
            </ul>
        </nav>
    </header>
    <section id="bestellungen">
        <h2>Pizzabäcker (bestellte Pizzen)</h2>
        <form action="https://echo.fbi.h-da.de/" method="post">
            <table>
                <tr>
                    <th></th>
                    <th>bestellt</th>
                    <th>im Ofen</th>
                    <th>fertig</th>
                </tr>
                <tr>
                    <td>Margherita</td>
                    <td><input type="radio" id="margherita_bestellt" name="margherita_status" value="bestellt"></td>
                    <td><input type="radio" id="margherita_imOfen" name="margherita_status" value="imOfen"></td>
                    <td><input type="radio" id="margherita_fertig" name="margherita_status" value="fertig"></td>
                </tr>
                <tr>
                    <td>Salami</td>
                    <td><input type="radio" id="salami_bestellt" name="salami_status" value="bestellt"></td>
                    <td><input type="radio" id="salami_imOfen" name="salami_status" value="imOfen"></td>
                    <td><input type="radio" id="salami_fertig" name="salami_status" value="fertig"></td>
                </tr>
                <tr>
                    <td>Prosciutto</td>
                    <td><input type="radio" id="prosciutto_bestellt" name="prosciutto_status" value="bestellt"></td>
                    <td><input type="radio" id="prosciutto_imOfen" name="prosciutto_status" value="imOfen"></td>
                    <td><input type="radio" id="prosciutto_fertig" name="prosciutto_status" value="fertig"></td>
                </tr>
                <!-- Fügen Sie hier weitere Zeilen für andere Pizzas hinzu -->
            </table>
            <input type="submit" value="Status aktualisieren">
        </form>
    </section>
    <footer>
        <p>© 2024 Pizzaservice</p>
    </footer>
</body>
</html>
HTML;

echo $html;
?>
