<?php

include("funktionen.php");
if (!isset($_SESSION["Spieler"])) {
    header('location: index.php');
}

?>

<html>

<head>
    <title>Steinbruch</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background-color:burlywood">
    <div class="Zurückbutton">
        <a href="/karte.php" onclick="PlaySound();"><img src="Bilder/Zurückbutton.png" /></a>
    </div>
    <div class="HandwerksContainer">
        <div class="HandwerkItemContainer">
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