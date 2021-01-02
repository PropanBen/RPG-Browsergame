<?php

session_start();
if (!isset($_SESSION["Spieler"])) {
    header('location: index.php');
}
?>

<html>

<head>
    <title>Taverne</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body onload="Geldabholen();">
    <div class="HintergrundTaverne"></div>
    <div class="Zurückbutton">
        <a href="/rpg.php" onclick="PlaySound();"><img src="Bilder/Zurückbutton.png" /></a>
    </div>

    <div class="Spielfeld" id="Spielfeld">
        <div class="PlatzhalterWuerfeln"></div>
        <div class="Spiel">
            <div id="Spieler">
                <p>Spieler</p>
            </div>
            <div id="p"><img id="hp" src="Bilder/Tisch.png"></div>
            <div id="GegenSpieler">
                <p>GegenSpieler</p>
            </div>
            <div id="npc"><img class="Ben" id="hnpc" src="Bilder/Tisch.png"></div>
        </div>

        <div class="label">
            <div class="button">
                <label id="Meldung"></label>
                <input type="image" id="Button" src="/Bilder/Würfel.png" onclick="roll()" value="Würfeln">
                <p>Weiter würfeln </p>
                </input>
                <input type="image" id="NButton" src="/Bilder/WürfelX.png" onclick="winner()" value="Nicht mehr Würfeln">
                <p>Nicht mehr würfeln</p></input><br><br>
                <input type="image" id="New" src="/Bilder/HolzTextButtonNeuesSpiel.png" onclick="reset();" value="Neues Spiel">
            </div>
            <label>Einsatz :&nbsp <label id="Einsatzwert">0</label></label> <br>
            <label>Guthaben : &nbsp <label id="Guthaben">0</label></label> <br>
            <div class="button">
                <input type="text" id="Text">
                <input id="setzen" type="image" src="/Bilder/HolzTextButtonSetzen.png" onclick="Setzen()"></input>
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

<script type="text/javascript" src="wuerfeln.js"></script>

</html>