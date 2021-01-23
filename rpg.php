<?php
include("funktionen.php");
?>

<html>

<head>
    <title>Propania</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="Hintergrund"></div>
    <div class="Content">
        <div class="Navigation">
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
            <div class="Navigationsleiste">

                <div class="NavigationItem">
                    <a href="/spieleruebersicht.php" onclick="PlaySound();"> <img src="/Bilder/Spieleruebersicht.png"></a>
                </div>
                <div class="NavigationItem">
                    <a href="/karte.php" onclick="PlaySound();"> <img src="/Bilder/SzeneMap.png"></a>
                </div>
                <div class="NavigationItem">
                    <div id="Berufdiv" onclick="PopUp('#Berufsfenster');">
                        <img src="/Bilder/Handwerk.png">
                    </div>
                </div>
                <div class="NavigationItem">
                    <div id="Inventardiv" onclick="PopUp('#Inventarfenster');">
                        <img src="/Bilder/Kiste.png">
                    </div>
                </div>
                <div class="NavigationItem">
                    <div id="Nachrichten">
                        <img src="/Bilder/Schriftrolle.png">
                        <div id="Schriftrolle" onclick="PopUp('#Nachrichtenfenster');">
                            <p><?php echo $newClass->AnzahlNachrichtenLesen($connection) ?></p>
                        </div>
                    </div>
                </div>
                <div class="NavigationItem">
                    <a class="Einstellungen" href="/einstellungen.php" onclick="PlaySound();"><img src="/Bilder/Einstellungen.png"></a>
                </div>
                <div class="NavigationItem">
                    <div class="form">
                        <form action="/login.php" method="POST">
                            <input type="hidden" name="action" value="Ausloggen" />
                            <input type="submit" class="Auslogbutton" value="" onclick="PlaySound();" />
                        </form>
                    </div>
                </div>
            </div>

            <div class="Menu">
                <div class="MarktplatzContainer">
                    <p class="Beschriftung">Geheim</p>
                    <div class="Aktionsbilder">
                        <a href="/rpg.php" onclick="PlaySound();"><img src="Bilder/HolzTextButtonNichtverfuegbar.png" /></a>
                    </div>
                </div>
                <div class="MarktplatzContainer">
                    <p class="Beschriftung">Taverne</p>
                    <div class="Aktionsbilder">
                        <a href="/taverne.php" onclick="PlaySound();"><img src="Bilder/Tavernenschild.png" /></a>
                    </div>
                </div>
                <div class="MarktplatzContainer">
                    <p class="Beschriftung">Marktplatz</p>
                    <div class="Aktionsbilder">
                        <a href="/marktplatz.php" onclick="PlaySound();"><img src="Bilder/Marktplatzbutton.png" /></a>
                    </div>
                </div>

                <div class="PVPKampfContainer">
                    <p class="Beschriftung">PVP Kampf</p><br>
                    <div class="Aktionsbilder">
                        <a href="/spielergegner.php" onclick="PlaySound();"><img src="Bilder/PVP.png" /></a>
                    </div>
                </div>
                <div class="PVEKampfContainer">
                    <p class="Beschriftung">PVE Kampf</p><br>
                    <div class="Aktionsbilder">
                        <a href="/themen.php" onclick="PlaySound();"><img src="Bilder/PVE.png" /></a><br><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="SzenenContainer">
            <!-- <img class="Szenenbild" src="Bilder/SzeneMap.png">-->
            <div class="KartenContainer">
                <img id="Karte" src="/Bilder/SzeneMap.png">
                <?php $newClass->BerufeAufKarteAnzeigen($connection, 3); ?>
            </div>
        </div>
    </div>
    <div id="Nachrichtenfenster">
        <div class="Zurückbutton">
            <img src="Bilder/Zurückbutton.png" onclick="PopDown('#Nachrichtenfenster');" />
        </div>
        <div id="NachrichtenContainer">
            <div id="Nachricht">
                <?php $newClass->NachrichtenAnzeigen($connection); ?>
            </div>
        </div>
        <div class="NachrichtenSendeContainer">
            <label>Empfaenger : </label>
            <select id="spieler" name="empfaengerid">
                <option value="alle">Alle</option>
                <?php $newClass->SpielerSendenAnLesen($connection); ?>
            </select><br><br>
            <input id="absender" type="hidden" name="absender" value="<?php echo $_SESSION["Spieler"] ?>">
            <textarea id="nachrichtentext" name="text"></textarea>
            <img id="nachrichtsenden" src="/Bilder/HolzTextButtonSenden.png" onclick="NachrichtSenden();">
            <p style="color:red">Alle Nachrichten löschen</p>
            <img id="allenachrichtenloeschen" src="/Bilder/Mülltonne.png" onclick="AlleNachrichtLoeschen();">
        </div>
    </div>

    <div id="Berufsfenster">
        <div class="Zurückbutton">
            <img src="Bilder/Zurückbutton.png" onclick="PopDown('#Berufsfenster');" />
        </div>
        <div class="Beruf-Grid-Container">
            <?php $newClass->BerufeAnzeigen($connection); ?>
        </div>
    </div>
    <div id="Inventarfenster">
        <div class="Zurückbutton">
            <img src="Bilder/Zurückbutton.png" onclick="PopDown('#Inventarfenster');" />
        </div>
        <div class="InventarContainer">
            <div class="Inventar">
                <?php $newClass->InventarAnzeigen($connection, "rpg.php"); ?>
            </div>
        </div>
    </div>
</body>

<script>
    function ItemLoeschen(slotid) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=itemloeschen&slotid=" + slotid + "");

        $("#Inventarfenster").load(location.href + "/rpg.php #Inventarfenster>*");
        PlaySound();
    }


    let nachricht = document.getElementById('Nachricht');

    function PlaySound() {
        //onclick="PlaySound();"

        var audio = new Audio('/Audio/tap.wav');
        audio.play();
    }

    function PopUp(element) {

        let popup
        popup = document.querySelector(element)
        if (popup !== null) {
            popup.style.opacity = 1;
            popup.style.transform = "translate(+0%, +0%) scale(1)";
        }
        var audio = new Audio('/Audio/tap.wav');
        audio.play();

    }

    function PopDown(element) {
        let popup
        popup = document.querySelector(element)
        if (popup !== null) {
            popup.style.opacity = 0;
            popup.style.transform = "translate(+0%, +0%) scale(0)";
        }
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
        $("#Nachricht").load(location.href + "/einstellungen.php #Nachricht>*");
        $("#Schriftrolle").load(location.href + "/einstellungen.php #Schriftrolle >*");
    }
    // Nachrichten Senden
    function NachrichtSenden() {
        var audio = new Audio('/Audio/tap.wav');
        audio.play();

        let empfaengerid = document.getElementById('spieler');
        let nachrichtentext = document.getElementById('nachrichtentext');
        let absender = document.getElementById('absender');

        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + empfaengerid.value + "&nachrichtentext=" + nachrichtentext.value + "&absender=" + absender.value + "");
        nachrichtentext.value = "";
        $("#Nachricht").load(location.href + "/einstellungen.php #Nachricht");
    }

    // Nachrichtloeschen

    function NachrichtLoeschen(id) {
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("nachrichtloeschen=true&id=" + id);
        $("#Nachricht").load(location.href + "/einstellungen.php #Nachricht");
    }

    function AlleNachrichtLoeschen() {
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("allenachrichtenloeschen=true");
        $("#Nachricht").load(location.href + "/einstellungen.php #Nachricht");
    }

    function LehrgeldZahlen(berufsid) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("berufkaufen=" + berufsid + "");
        $("#Berufsfenster").load(location.href + "/rpg.php #Berufsfenster>*");
        $("#geldcontainer").load(location.href + "/rpg.php #geldcontainer>*");
        var audio = new Audio('/Audio/coin.wav');
        audio.play();
    }
</script>

</html>