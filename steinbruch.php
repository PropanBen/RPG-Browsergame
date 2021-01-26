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
        <div id="ItemAnzeige">
            <?php $newClass->RohstoffeAnzeigen($connection, "Steinmetz", 0);  ?>
        </div>
        <div class="UmgebungsContainer">
        </div>
        <div class="Inventar">
            <?php $newClass->InventarAnzeigen($connection, NULL); ?>
        </div>
    </div>

    </div>


</body>
<script>
    function PlaySound() {
        var audio = new Audio('/Audio/tap.wav');
        audio.play();
    }

    function PlaySoundError() {
        var audio = new Audio('/Audio/error.wav');
        audio.play();
    }

    function ItemVor() {
        let index = document.getElementById('index');
        let itemanzahl = document.getElementById('itemanzahl');
        let typ = document.getElementById('typ');

        let maxindex = itemanzahl.value - 1;

        if (index.value < maxindex) {
            index.value++;
            ItemAnfrage(index.value, typ.value);
            PlaySound();
        } else {
            PlaySoundError();
        }

    }

    function ItemZurueck() {
        let index = document.getElementById('index');
        let itemanzahl = document.getElementById('itemanzahl');
        let typ = document.getElementById('typ');

        let maxindex = itemanzahl.value;

        if (index.value > 0) {
            index.value--;
            ItemAnfrage(index.value, typ.value);
            PlaySound();
        } else {
            PlaySoundError();
        }

    }

    function ItemAnfrage(index, typ) {
        let divbox = document.getElementById('ItemAnzeige')
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                divbox.innerHTML = this.responseText;
            }
        }
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=itemanfrage&index=" + index + "&typ=" + typ + "");
    }
</script>

</html>