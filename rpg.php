<?php
include("funktionen.php");
?>

<html>

<head>
    <title>Propania</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<div class="Content">
    <div class="Navigation">
        <div class="SpielerInfoContainer">
            <div class="Avatarbild">
                <img class="Spielerbildrahmen" src="/Bilder/Rahmen.png" />
                <img class="Spielerbild" src="<?php echo $newClass->SpielerLesen($connection, "spielerbildpfad", $_SESSION["Spieler"]) ?>">
                <img id="LvLPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                <div class="LvL">
                    <p><?php echo $newClass->SpielerLesen($connection, "lvl", $_SESSION["Spieler"]) ?></p>
                </div>
                <div class="Bildupload">
                    <form id="inputform" action="./funktionen.php" method="POST" enctype="multipart/form-data">
                        <!-- 3,5 mb maximal dateigröße -->
                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                        <label>Bild</label><br>
                        <label for="bild-hochladen" class="Angepasster-Input">Upload</label><br>
                        <input id="bild-hochladen" type="file" name="bildhochladen" />
                        <input id="subbtn" class="Avatarbutton" type="image" src="/Bilder/Haken.png" />
                        <button type="reset" style="border: 0; background: transparent">
                            <img class="Avatarbutton" src="/Bilder/X.png" />
                        </button>
                    </form>
                </div>
            </div>
            <div class="Ausruestung">
                <div class="RuestungContainer">
                    <img class="Ruestungsbild" src="<?php $newClass->BildLesen($connection, "ruestungsbildpfad", "ruestung", "ruestungsid", $_SESSION["Spieler"]); ?>" width="40" height="40">
                    <img id="RuestungsPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                    <div class="ruestungswert">
                        <p><?php echo $newClass->SpielerRuestungsStatsLesen($connection, "ruestungswert", $newClass->SpielerLesen($connection, "ruestungsid", $_SESSION["Spieler"])) ?></p>
                    </div>
                    <div class="Ruestungsname"><?php $newClass->BildLesen($connection, "ruestungsname", "ruestung", "ruestungsid", $_SESSION["Spieler"]); ?></div>
                </div>
                <div class="WaffenCont">
                    <img class="Waffenbild" src="<?php $newClass->BildLesen($connection, "waffenbildpfad", "waffen", "waffenid", $_SESSION["Spieler"]); ?>" width="40" height="40">
                    <img id="RuestungsPlakette" class="Plakette" src="/Bilder/LvL_Plakette.png" />
                    <div class="waffenwert">
                        <p><?php echo $newClass->SpielerWaffenStatsLesen($connection, "waffenwert", $newClass->SpielerLesen($connection, "waffenid", $_SESSION["Spieler"])) ?></p>
                    </div>
                    <div class="Waffenname"><?php $newClass->BildLesen($connection, "waffenname", "waffen", "waffenid", $_SESSION["Spieler"]); ?></div>
                </div>
            </div>
            <div class="Stats">
                <p id="spielername"><?php echo $_SESSION["Spieler"]; ?></p><br>
                <img src="Bilder/Leben.png">
                <label>Leben</label>
                <p id="leben"><?php echo $newClass->SpielerLesen($connection, "leben", $_SESSION["Spieler"]) ?>&nbspvon&nbsp<?php echo $newClass->SpielerLesen($connection, "maxleben", $_SESSION["Spieler"]) ?> </p><br>
                <img src="Bilder/XP.png">
                <label>Erfahrung</label>
                <p id="erfahrung"><?php echo $newClass->SpielerLesen($connection, "erfahrung", $_SESSION["Spieler"]) ?>&nbspvon&nbsp<?php $newClass->MAXErfahrung($connection, $_SESSION["Spieler"]) ?></p>
                <div id="geldcontainer">
                    <label>Geld</label>
                    <p id="geld"><?php echo $newClass->SpielerLesen($connection, "geld", $_SESSION["Spieler"]) ?></p>
                    <img src="Bilder/Geld.png">
                </div>
                <div class="form">
                    <form action="/index.php" method="POST">
                        <input type="image" src="/Bilder/Ausloggen.png" name="action" value="Ausloggen" />
                    </form>
                </div>
            </div>
        </div>

        <div class="SpielerlisteContainer">
            <p>Spieleruebersicht</p>
            <div class="Spielerliste">
                <p><?php $newClass->AlleSpielerLesen($connection) ?></p>
            </div>
            <?php $newClass->AdminEinblenden($connection, $_SESSION["Spieler"]); ?><br>
        </div>

        <div class="MarktplatzContainer">
            <p class="Beschriftung">Marktplatz</p>
            <div class="Aktionsbilder">
                <a href="/marktplatz.php"><img src="Bilder/Marktplatzbutton.png" /></a>
            </div>
        </div>

        <div class="PVPKampfContainer">
            <p class="Beschriftung">PVP Kampf</p><br>
            <div class="Aktionsbilder">
                <a href="/spielergegner.php"><img src="Bilder/PVP.png" /></a>
            </div>
        </div>
        <div class="PVEKampfContainer">
            <p class="Beschriftung">PVE Kampf</p><br>
            <div class="Aktionsbilder">
                <a href="/themen.php"><img src="Bilder/PVE.png" /></a><br><br>
            </div>
        </div>
    </div>
    <div class="SzenenContainer">
        <img class="Szenenbild" src="Bilder/Szene.png">
    </div>
</div>

</html>