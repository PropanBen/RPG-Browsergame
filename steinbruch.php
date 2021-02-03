<?php

include("funktionen.php");
if (!isset($_SESSION["Spieler"])) {
    header('location: index.php');
}


if ($newClass->Berufpruefen($connection, 3) == 0)
    header('location: rpg.php');
?>

<html>

<head>
    <title>Steinbruch</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<div class="Hintergrund"></div>

<body style="background-color:burlywood">
    <div class="Zurückbutton">
        <a href="/karte.php" onclick="PlaySound();"><img src="Bilder/Zurückbutton.png" /></a>
    </div>
    <div class="HandwerksContainer">
        <div id="ItemAnzeige">
            <?php $newClass->RohstoffeAnzeigen($connection, 3, "Steinmetz", 0);  ?>
        </div>
        <div id="Werte">
            <p id="XP">XP : <?php echo $newClass->BerufsfortschrittLesen($connection, 3); ?>&nbsp /&nbsp <?php echo $newClass->BerufsfortschrittLvLLesen($connection, 3) * 1000; ?></p>
            <p id="beruf"> <?php echo $newClass->BerufsnameVonID($connection, 3); ?>&nbspLvL :&nbsp<?php echo $newClass->BerufsfortschrittLvLLesen($connection, 3); ?></p>
        </div>
        <div class="UmgebungsContainer">
            <div class="AktionsButtonContainer">
                <input id="Werkzeug" type="image" onclick="ItemSammeln();" src="/Berufsbilder/Spitzhacke1.png">
            </div>
        </div>
        <div id="Inventar" class="Inventar">
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
        let divbox = document.getElementById('ItemAnzeige');
        let berufsid = document.getElementById('berufsid');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                divbox.innerHTML = this.responseText;
            }
        }
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=itemanfrage&index=" + index + "&typ=" + typ + "&berufsid=" + berufsid.value + "");
    }

    function ItemSammeln() {
        let berufsid = 3;
        let itemid = document.getElementById('itemid');
        let werkzeug = document.getElementById('Werkzeug');
        let inventar = document.getElementById('Inventar');
        werkzeug.style.transform = "translate(+0%, +0%) scale(1.2)";
        setTimeout(Skalieren, 200);

        var audio = new Audio('/Audio/Spitzhacke.wav');
        audio.play();

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == 1) {
                    var audio = new Audio('/Audio/Steinbruch.wav');
                    audio.play();
                    inventar.style.transform = "translate(+0%, +0%) scale(1.1)";
                    $("#XP").load(location.href + "/steinbruch.php #XP");
                    $("#beruf").load(location.href + "/steinbruch.php #beruf");
                    setTimeout(InventarSkalieren, 1000);
                }

            }
        }
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=itemabbauen&berufsid=" + berufsid + "&itemid=" + itemid.value + "");
        $(".Inventar").load(location.href + "/steinbruch.php .Inventar");

    }

    function Skalieren() {
        let werkzeug = document.getElementById('Werkzeug');
        werkzeug.style.transform = "translate(+0%, +0%) scale(1.0)";
    }

    function InventarSkalieren() {
        let inventar = document.getElementById('Inventar');
        inventar.style.transform = "translate(+0%, +0%) scale(1.0)";
    }
</script>

</html>