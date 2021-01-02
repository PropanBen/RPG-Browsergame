<?php
include("funktionen.php");
?>

<html>

<head>
    <title>Themen</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="Hintergrund"></div>

    <div class="Zurückbutton">
        <a href="/rpg.php" onclick="PlaySound();"><img src="Bilder/Zurückbutton.png" /></a>
    </div>
    <div class="WaffenContainer">
        <p class="Überschrift">Themenuebersicht</p>
        <div class="Waffenliste">
            <?php $newClass->ThemenAnzeigen($connection) ?>
        </div>
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