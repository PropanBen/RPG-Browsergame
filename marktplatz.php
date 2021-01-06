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

    <div class="Überschrift">
        <p>Marktplatz</p>
    </div>
    <div class="NavigationMarktplatz">
        <div class="SpielerInfoContainer">
            <p id="spielername"><?php echo $_SESSION["Spieler"]; ?></p>
            <p id="Titel"><?php echo $newClass->TitelAnzeigen($connection, $_SESSION["Spielerid"]) ?></p><br>
            <div class="Avatarbild">
                <img class="Spielerbildrahmen" src="/Bilder/Rahmen.png" />
                <img class="Spielerbild" src="<?php echo $newClass->SpielerLesen($connection, "spielerbildpfad", $_SESSION["Spieler"]) ?>">
                <img id="LvLPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                <div class="LvL">
                    <p><?php echo $newClass->SpielerLesen($connection, "lvl", $_SESSION["Spieler"]) ?></p><br>
                </div>
            </div>
            <div class="Ausruestung">
                <div class="AusruestungItem">
                    <div class="RuestungContainer">
                        <img src="/Bilder/Verteidigung.png">
                        <img id="RuestungsPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                        <div class="verteidigung">
                            <p><?php echo $newClass->SpielerLesen($connection, "verteidigung", $_SESSION["Spieler"]) ?></p>
                        </div>
                        <p>Verteidigung</p>
                    </div>
                    <div class=" RuestungContainer">
                        <img src="/Bilder/Angriff.png">
                        <img id="RuestungsPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                        <div class="angriff">
                            <p><?php echo $newClass->SpielerLesen($connection, "angriff", $_SESSION["Spieler"]) ?></p>
                        </div>
                        <p>Angriff</p>
                    </div>
                </div>
                <div class="AusruestungItem">
                    <div class="RuestungContainer">
                        <img class="Ruestungsbild" src="<?php $newClass->BildLesen($connection, "ruestungsbildpfad", "ruestung", "ruestungsid", $_SESSION["Spieler"]); ?>">
                        <img id="RuestungsPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                        <div class="ruestungswert">
                            <p><?php echo $newClass->SpielerRuestungsStatsLesen($connection, "ruestungswert", $newClass->SpielerLesen($connection, "ruestungsid", $_SESSION["Spieler"])) ?></p>
                        </div>
                        <p><?php $newClass->BildLesen($connection, "ruestungsname", "ruestung", "ruestungsid", $_SESSION["Spieler"]); ?></p>
                    </div>
                    <div class="RuestungContainer">
                        <img class="Waffenbild" src="<?php $newClass->BildLesen($connection, "waffenbildpfad", "waffen", "waffenid", $_SESSION["Spieler"]); ?>">
                        <img id="RuestungsPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                        <div class="waffenwert">
                            <p><?php echo $newClass->SpielerWaffenStatsLesen($connection, "waffenwert", $newClass->SpielerLesen($connection, "waffenid", $_SESSION["Spieler"])) ?></p>
                        </div>
                        <p><?php $newClass->BildLesen($connection, "waffenname", "waffen", "waffenid", $_SESSION["Spieler"]); ?></p>
                    </div>
                </div>
            </div>
            <div class="Stats">
                <img src="Bilder/Leben.png">
                <label>Leben</label>
                <p id="leben"><?php echo $newClass->SpielerLesen($connection, "leben", $_SESSION["Spieler"]) ?>&nbsp/&nbsp<?php echo $newClass->SpielerLesen($connection, "maxleben", $_SESSION["Spieler"]) ?> </p><br>
                <img src="Bilder/XP.png">
                <label>Erfahrung</label>
                <p id="erfahrung"><?php echo $newClass->SpielerLesen($connection, "erfahrung", $_SESSION["Spieler"]) ?>&nbsp/&nbsp<?php $newClass->MAXErfahrung($connection, $_SESSION["Spieler"]) ?></p>
                <div id="geldcontainer">
                    <label>Geld</label>
                    <p id="geld"><?php echo $newClass->SpielerLesen($connection, "geld", $_SESSION["Spieler"]) ?></p>
                    <img src="Bilder/Geld.png">
                </div>
            </div>
        </div>
    </div>
    <div class="WaffenContainer">
        <p class="Überschrift">Heilstube</p>
        <div class="Waffenliste">
            <?php $newClass->AlleTraenkeLesen($connection) ?>
        </div>
    </div>
    <div class="WaffenContainer">
        <p class="Überschrift">Waffenschmied</p>
        <div class="Waffenliste">
            <?php $newClass->AlleWaffenLesen($connection) ?>
        </div>
    </div>

    <div class="WaffenContainer">
        <p class="Überschrift">Rüstungsschmied</p>
        <div class="Waffenliste">
            <?php $newClass->AlleRüstungenLesen($connection) ?>
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