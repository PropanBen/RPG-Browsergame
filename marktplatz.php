<?php

// Bei Kauf Sound abspielen
if (isset($_POST["trankid"]) || isset($_POST["waffenid"]) || isset($_POST["ruestungsid"])) {
    $myAudioFile = "/Audio/coin.wav";
    echo '<audio autoplay="true">
<source src="' . $myAudioFile . '" type="audio/wav">
</audio>';
}

include("funktionen.php");
if (!isset($_SESSION["Spieler"])) {
    header('location: index.php');
}
?>

<html>

<head>
    <title>Marktplatz</title>
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

    <div class="Platzhalter"></div>
    <div class="WaffenContainer">
        <p class="Überschrift">Marktplatz</p>
        <div class="Waffenliste">
            <div class=GegenstandEinzeln>
                <p>Heilstube</p>
                <a href="/heilstube.php"><img src='/Bilder/Marktplatzbutton.png' width=100 height=100 onclick="PlaySound();"></a>
            </div>
            <div class=GegenstandEinzeln>
                <p>Waffenschmied</p>
                <a href="/waffenschmied.php"><img src='/Bilder/Marktplatzbutton.png' width=100 height=100 onclick="PlaySound();"></a>
            </div>
            <div class=GegenstandEinzeln>
                <p>Rüstungsschmied</p>
                <a href="/ruestungsschmied.php"><img src='/Bilder/Marktplatzbutton.png' width=100 height=100 onclick="PlaySound();"></a>
            </div>
            <div class=GegenstandEinzeln>
                <p>Händler</p>
                <a href="/haendler.php"><img src='/Bilder/Marktplatzbutton.png' width=100 height=100 onclick="PlaySound();"></a>
            </div>
            <div class=GegenstandEinzeln>
                <p>Rohstoffhändler</p>
                <a href="/rohstoffhaendler.php"><img src='/Bilder/Marktplatzbutton.png' width=100 height=100 onclick="PlaySound();"></a>
            </div>
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