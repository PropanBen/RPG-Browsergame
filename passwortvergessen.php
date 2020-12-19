<?php
session_start();

if (!isset($_SESSION["Erfolg"])) {
    $_SESSION["Erfolg"] = null;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Passwort Vergessen</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="rpgstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>
    <div class="Hintergrund"></div>
    <div class="Inhalt">
        <div class="Logo">
            <img src="Bilder/Propania.png" />
        </div>

        <div class="LoginContainer">
            <form action="/login.php" method="POST">
                <label>E-Mail Adresse :</label>
                <input type="text" id="email" name="email" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" title="Beispiel example@example.com" required><br>
                <p id="fehler"><?php echo $_SESSION["Erfolg"] ?></p>
                <div class="LoginButtons">
                    <button id="submitbutton" type="submit" name="action" value="vergessen" style="border: 0; background: transparent"><img src="/Bilder/HolzTextButtonZurücksetzen.png"></button>
                    <button type="reset" style="border: 0; background: transparent"><img src="/Bilder/HolzTextButtonEntfernen.png"></button>
                </div>
            </form>
        </div>
        <div class="Zurückbutton">
            <a href="/index.php"><img src="Bilder/Zurückbutton.png" /></a>
        </div>
</body>

<script>
    let button = document.getElementById("submitbutton");
    let fehler = document.getElementById("fehler");
    button.addEventListener('click', Absenden);

    function Absenden() {
        fehler.text = "Abgesendet";
    }
</script>

</html>