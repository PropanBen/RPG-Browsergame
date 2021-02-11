<?php

include("funktionen.php");
if (!isset($_SESSION["Spieler"])) {
    header('location: index.php');
}


if ($newClass->Berufpruefen($connection, 2) == 0)
    header('location: rpg.php');
?>

<html>

<head>
    <title>Holzfäller</title>
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
    <div class="HandwerksContainer" style="background-image : url('/Orte/Holzfäller.png');">
        <div id="ItemAnzeige">
            <?php $newClass->RohstoffeAnzeigen($connection, 2, "Holzfaeller", 0);  ?>
        </div>
        <div id="Werte">
            <p id="XP">XP : <?php echo $newClass->BerufsfortschrittLesen($connection, 2); ?>&nbsp /&nbsp <?php echo $newClass->BerufsfortschrittLvLLesen($connection, 2) * 1000; ?></p>
            <p id="beruf"> <?php echo $newClass->BerufsnameVonID($connection, 2); ?>&nbspLvL :&nbsp<?php echo $newClass->BerufsfortschrittLvLLesen($connection, 2); ?></p>
        </div>
        <div class="UmgebungsContainer">
            <div class="SaegeContainer">
                <input type="range" min="1" max="100" value="50" class="Saege" id="WerkzeugSaege">
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

    function PlaySoundSaw1() {
        var audio = new Audio('/Audio/saegen.wav');
        audio.play();
    }

    function PlaySoundSaw2() {
        var audio = new Audio('/Audio/saegen2.wav');
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

    function ItemSammeln(index) {
        let berufsid = 2;
        let itemid = document.getElementById('itemid');
        let werkzeug = document.getElementById('WerkzeugSaege');
        let inventar = document.getElementById('Inventar');
        werkzeug.style.transform = "translate(+0%, +0%) scale(1.2)";

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == 1) {
                    var audio = new Audio('/Audio/baumfaellt.wav');
                    audio.play();
                    inventar.style.transform = "translate(+0%, +0%) scale(1.1)";
                    $("#XP").load(location.href + "/holzfaeller.php #XP");
                    $("#beruf").load(location.href + "/holzfaeller.php #beruf");
                    setTimeout(InventarSkalieren, 1000);
                }
                if (this.responseText == 2) {

                    if (index == 1)
                        PlaySoundSaw1();
                    if (index == 2)
                        PlaySoundSaw2();

                }

            }
        }
        xhttp.open("POST", "funktionen.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=itemabbauen&berufsid=" + berufsid + "&itemid=" + itemid.value + "");
        $(".Inventar").load(location.href + "/holzfaeller.php .Inventar");

    }


    function InventarSkalieren() {
        let inventar = document.getElementById('Inventar');
        inventar.style.transform = "translate(+0%, +0%) scale(1.0)";
    }

    var slider = document.getElementById("WerkzeugSaege");
    var sperre = 0;

    slider.oninput = function() {
        if (sperre == 0 && this.value == 1) {
            sperre = 1;
            console.log("1");
            ItemSammeln(1);
        }
        if (sperre == 1 && this.value == 100) {
            sperre = 0;
            ItemSammeln(2);
        }
    }
</script>

</html>