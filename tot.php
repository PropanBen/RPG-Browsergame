<?php
session_start();



?>

<!DOCTYPE html>
<html>

<head>
    <title>Tot</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="rpgstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>
    <div class="Hintergrund"></div>
    <div class="Inhalt">

        <div class="Platzhalter"></div>
        <div class="LoginContainer">
            <form>
                <img src="/Bilder/Leben.png" width="200" height="200"><br>
                <p>Schwer verletzt !<br><br>
                    Du wurdest von einem Fremden
                    gefunden und zu einem Arzt gebracht.
                    Der Arzt konnte dein Leben retten.<br>
                    Du fühlst dich aber geschwaecht und hast deine Ausrüstung verloren.
                    Der Fremde drückt dir etwas in die Hand um wieder auf die Beine zu kommen

                </p>
            </form>
        </div>
        <div class="Zurückbutton">
            <a href="/rpg.php" onclick="PlaySound();"><img src="Bilder/Zurückbutton.png" /></a>
        </div>
</body>

<script>
    function PlaySound() {
        //onclick="PlaySound();"
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
    }
</script>

</html>