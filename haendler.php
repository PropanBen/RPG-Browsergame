<?php

// Bei Kauf Sound abspielen
if (isset($_POST["trankid"]) || isset($_POST["waffenid"]) || isset($_POST["ruestungsid"]) || isset($_POST["action"])) {
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
    <title>Händler</title>
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
    <div class="NavigationMarktplatz">

        <div class="SpielerInfoContainer">
            <p id="spielername"><?php echo $_SESSION["Spieler"]; ?></p>

            <div class="Stats">
                <div id="geldcontainer">
                    <label>Geld</label>
                    <p id="geld"><?php echo $newClass->SpielerLesen($connection, "geld", $_SESSION["Spieler"]) ?></p>
                    <img src="Bilder/Geld.png">
                </div>
            </div>
        </div>
        <div class="Inventar">
            <?php $newClass->InventarAnzeigen($connection); ?>
        </div>
    </div>
    <div class="WaffenContainer">
        <p class="Überschrift">Händler</p>
        <div class="Waffenliste">
            <?php $newClass->HaendlerLesen($connection) ?>
        </div>
    </div>
    <br>
</body>

<script>
    function PlaySound() {
        //onclick="PlaySound();"
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
    }
</script>

</html>