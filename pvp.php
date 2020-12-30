<?php
include("funktionen.php");
?>

<html>

<head>
  <title>PVP</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
  <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
  <script type="text/javascript" src="pvpkampf.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body onload="DatenLaden();">
  <div class="Hintergrund"></div>

  <div class="Überschrift">
    <p>Spieler gegen Spieler</p>
  </div>

  <div class="RahmenContainer">
    <div class="SpielerRahmenLinks">
      <p id="spieler1name" class="spielername1">Hans</p>
      <div class="SpielerBildRahmenLinks">
        <img id="spieler1bild" class="SpielerBildLinks" src="Spieleravatare/Ritter.png" alt="Bild links">
        <div id="RuestungRahmenLinks">
          <img id="spieler1ruestungsbild" class="RuestungsBilder" src="/Ruestungsbilder/Ruestung_Default.png">
          <div id="PVERPC">
            <img class="Plakette" src="/Bilder/LvL_Plakette.png" />
            <p id="spieler1ruestungswert" class="ruestungswert1">20</p>
          </div>
        </div>
        <div id="LebenRahmenMitte">
          <div class="lebentext1">
            <p id="spieler1leben" class="leben1">10</p>
            <p class="von">/</p>
            <p id="spieler1maxleben" class="maxleben1">100</p>
          </div>
        </div>
        <div id="AngriffRahmenLinks">
          <img id="spieler1waffenbild" class="AngriffBild" src="/Waffenbilder/Waffe_Default.png">
          <div id="PVEAPC">
            <img class="Plakette" src="/Bilder/LvL_Plakette.png" />
            <p id="spieler1angriff" class="angriffswert1">10</p>
          </div>
        </div>
      </div>
    </div>
    <div class="SpielerRahmenRechts">
      <p id="spieler2name" class="spielername2">Ben</p>
      <div class="SpielerBildRahmenRechts">
        <img id="spieler2bild" class="SpielerBildRechts" src="Spieleravatare/Ritter.png" alt="Bild rechts">
        <div id="RuestungRahmenRechts">
          <img id="spieler2ruestungsbild" class="RuestungsBilder" src="/Ruestungsbilder/Ruestung_Default.png">
          <div id="PVEGLPC">
            <img class="Plakette" src="/Bilder/LvL_Plakette.png" />
            <p id="spieler2ruestungswert">10</p>
          </div>
        </div>
        <div id="LebenRahmenMitte2" class="Le">
          <div class="lebentext2">
            <p id="spieler2leben" class="leben2">5</p>
            <p class="von">/</p>
            <p id="spieler2maxleben" class="maxleben2">80</p>
          </div>
        </div>
        <div id="AngriffRahmenRechts">
          <img id="spieler2waffenbild" class="AngriffBild" src="/Waffenbilder/Waffe_Default.png">
          <div id="PVEGLPC">
            <img class="Plakette" src="/Bilder/LvL_Plakette.png" />
            <p id="spieler2angriff">5</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="Kampfergebnisse" class="KampfergebnisseContainer">
    <p id="kampfgewinner"></p>
    <p id="kampfgeld"></p>
    <p id="kampferfahrung"></p>
    <p id="kampfgeldverlust"></p>
    <p id="lvlup"></p>
    <div class="Zurückbutton">
      <a id="todesermittler" href="/spielergegner.php" onclick="PlaySound();"><img src="Bilder/Zurückbutton.png" width="100" height="100" /></a>
    </div>
  </div>

  <div class="Zurückbutton">
    <button id="kampfstartenbutton" onclick="KampfStarten(SpielerDatenLaden(),SpielerGegnerDatenLaden())">
      <img src="Bilder/Kampf.png"></button>
  </div>

</body>
<script type="text/javascript">
  function PlaySound() {
    //onclick="PlaySound();"
    var audio = new Audio('/Audio/tap.wav');
    audio.play();
  }

  function DatenLaden() {
    //json_encode($str, JSON_UNESCAPED_SLASHES)
    const spielerdaten = <?php json_encode($newClass->JSONStringSpieler($connection, $_SESSION["Spieler"]), JSON_UNESCAPED_SLASHES); ?>;
    const spielergegnerdaten = <?php json_encode($newClass->JSONStringSpieler($connection, $_POST["spielergegner"]), JSON_UNESCAPED_SLASHES); ?>;

    //Spieler Daten in Frontend laden
    let spieler1ruestungswert = spielerdaten[0]["ruestungswert"] + spielerdaten[0]["verteidigung"];
    let spieler1ruestungsbildpfad = spielerdaten[0]["ruestungsbildpfad"];
    let spieler1leben = spielerdaten[0]["leben"];
    let spieler1maxleben = spielerdaten[0]["maxleben"];
    let spieler1schaden = spielerdaten[0]["angriff"] + spielerdaten[0]["waffenwert"];
    let spieler1waffenbild = spielerdaten[0]["waffenbildpfad"];
    let spieler1bild = spielerdaten[0]["spielerbildpfad"];
    let spieler1name = spielerdaten[0]["spielername"];

    let uispieler1ruestungswert = document.getElementById('spieler1ruestungswert');
    let uispieler1ruestungsbild = document.getElementById('spieler1ruestungsbild');
    let uispieler1leben = document.getElementById('spieler1leben');
    let uispieler1maxleben = document.getElementById('spieler1maxleben');
    let uispieler1angriff = document.getElementById('spieler1angriff');
    let uispieler1waffenbild = document.getElementById('spieler1waffenbild');
    let uispieler1bild = document.getElementById('spieler1bild');
    let uispieler1name = document.getElementById('spieler1name');

    uispieler1ruestungswert.innerText = spieler1ruestungswert;
    uispieler1ruestungsbild.src = spieler1ruestungsbildpfad;
    uispieler1leben.innerText = spieler1leben;
    uispieler1maxleben.innerText = spieler1maxleben;
    uispieler1angriff.innerText = spieler1schaden;
    uispieler1waffenbild.src = spieler1waffenbild;
    uispieler1bild.src = spieler1bild;
    uispieler1name.innerText = spieler1name;

    // SpielerGegner in Frontend laden

    let spieler2ruestungswert = spielergegnerdaten[0]["ruestungswert"] + spielergegnerdaten[0]["verteidigung"];
    let spieler2ruestungsbildpfad = spielergegnerdaten[0]["ruestungsbildpfad"];
    let spieler2leben = spielergegnerdaten[0]["leben"];
    let spieler2maxleben = spielergegnerdaten[0]["maxleben"];
    let spieler2schaden = spielergegnerdaten[0]["angriff"] + spielergegnerdaten[0]["waffenwert"];
    let spieler2waffenbild = spielergegnerdaten[0]["waffenbildpfad"];
    let spieler2bild = spielergegnerdaten[0]["spielerbildpfad"];
    let spieler2name = spielergegnerdaten[0]["spielername"];

    let uispieler2ruestungswert = document.getElementById('spieler2ruestungswert');
    let uispieler2ruestungsbild = document.getElementById('spieler2ruestungsbild');
    let uispieler2leben = document.getElementById('spieler2leben');
    let uispieler2maxleben = document.getElementById('spieler2maxleben');
    let uispieler2angriff = document.getElementById('spieler2angriff');
    let uispieler2waffenbild = document.getElementById('spieler2waffenbild');
    let uispieler2bild = document.getElementById('spieler2bild');
    let uispieler2name = document.getElementById('spieler2name');

    uispieler2ruestungswert.innerText = spieler2ruestungswert;
    uispieler2ruestungsbild.src = spieler2ruestungsbildpfad;
    uispieler2leben.innerText = spieler2leben;
    uispieler2maxleben.innerText = spieler2maxleben;
    uispieler2angriff.innerText = spieler2schaden;
    uispieler2waffenbild.src = spieler2waffenbild;
    uispieler2bild.src = spieler2bild;
    uispieler2name.innerText = spieler2name;

  }

  function SpielerDatenLaden() {
    const spielerdaten = <?php json_encode($newClass->JSONStringSpieler($connection, $_SESSION["Spieler"]), JSON_UNESCAPED_SLASHES); ?>;
    let spielerlvl = spielerdaten[0]["lvl"];
    let spielererfahrung = spielerdaten[0]["erfahrung"];
    let spielerruestungswert = spielerdaten[0]["ruestungswert"] + spielerdaten[0]["verteidigung"];;
    let spielerruestungsbildpfad = spielerdaten[0]["ruestungsbildpfad"];
    let spielerleben = spielerdaten[0]["leben"];
    let uispielerruestungswert = document.getElementById('spieler1ruestungswert');
    let uispielerleben = document.getElementById('spieler1leben');
    let spielermaxleben = spielerdaten[0]["maxleben"];
    let spielerschaden = spielerdaten[0]["angriff"] + spielerdaten[0]["waffenwert"];
    let spielerangriffswert = spielerdaten[0]["angriff"];
    let spielerverteidigung = spielerdaten[0]["verteidigung"];
    let spielerwaffenbild = spielerdaten[0]["waffenbildpfad"];
    let spielerbild = spielerdaten[0]["spielerbildpfad"];
    let spielername = spielerdaten[0]["spielername"];
    let spielergeld = spielerdaten[0]["geld"];
    let Spieler = new Avatar(spielername, spielerlvl, spielerschaden, spielerruestungswert, spielerleben, uispielerruestungswert, uispielerleben, "links", spielergeld, SpielerErfahrungBerechnen(spielerlvl, spielermaxleben, spielerschaden, spielerruestungswert), spielererfahrung, spielerangriffswert, spielerverteidigung, spielermaxleben);
    return Spieler;
  }

  function SpielerGegnerDatenLaden() {
    const spielerdaten = <?php json_encode($newClass->JSONStringSpieler($connection, $_POST["spielergegner"]), JSON_UNESCAPED_SLASHES); ?>;
    let spielerlvl = spielerdaten[0]["lvl"];
    let spielererfahrung = spielerdaten[0]["erfahrung"];
    let spielerruestungswert = spielerdaten[0]["ruestungswert"] + spielerdaten[0]["verteidigung"];
    let spielerruestungsbildpfad = spielerdaten[0]["ruestungsbildpfad"];
    let spielerleben = spielerdaten[0]["leben"];
    let uispielerruestungswert = document.getElementById('spieler2ruestungswert');
    let uispielerleben = document.getElementById('spieler2leben');
    let spielermaxleben = spielerdaten[0]["maxleben"];
    let spielerschaden = spielerdaten[0]["angriff"] + spielerdaten[0]["waffenwert"];
    let spielerangriffswert = spielerdaten[0]["angriff"];
    let spielerverteidigung = spielerdaten[0]["verteidigung"];
    let spielerwaffenbild = spielerdaten[0]["waffenbildpfad"];
    let spielerbild = spielerdaten[0]["spielerbildpfad"];
    let spielername = spielerdaten[0]["spielername"];
    let spielergeld = spielerdaten[0]["geld"];
    let SpielerGegner = new Avatar(spielername, spielerlvl, spielerschaden, spielerruestungswert, spielerleben, uispielerruestungswert, uispielerleben, "rechts", spielergeld, SpielerErfahrungBerechnen(spielerlvl, spielerleben, spielerschaden, spielerruestungswert), spielererfahrung, spielerangriffswert, spielerverteidigung, spielermaxleben);
    return SpielerGegner;
  }

  function VersendenVorbereiten(Spieler, Gegner) {
    const spielerdaten = <?php json_encode($newClass->JSONStringSpieler($connection, $_SESSION["Spieler"]), JSON_UNESCAPED_SLASHES); ?>;
    const spielergegnerdaten = <?php json_encode($newClass->JSONStringSpieler($connection, $_POST["spielergegner"]), JSON_UNESCAPED_SLASHES); ?>;

    spielerdaten[0]["leben"] = Spieler.leben;
    spielerdaten[0]["erfahrung"] = Spieler.erfahrungdb;
    if (Spieler.geld < 0) {
      spielerdaten[0]["geld"] = 0;
    } else {
      spielerdaten[0]["geld"] = Spieler.geld;
    }
    spielerdaten[0]["lvl"] = Spieler.lvl;
    spielerdaten[0]["angriff"] = Spieler.angriffswert;
    spielerdaten[0]["verteidigung"] = Spieler.verteidigung;
    spielerdaten[0]["maxleben"] = Spieler.maxleben;

    if (spielerdaten[0]["leben"] == 0 && spielerdaten[0]["geld"] == 0) {
      document.getElementById("todesermittler").href = "/tot.php";
      spielerdaten[0]["leben"] = 3;
      spielerdaten[0]["erfahrung"] = 0;
      spielerdaten[0]["geld"] = 6;
      spielerdaten[0]["lvl"] = 1;
      spielerdaten[0]["angriff"] = 1;
      spielerdaten[0]["verteidigung"] = 0;
      spielerdaten[0]["maxleben"] = 3;
      spielerdaten[0]["waffenid"] = 0;
      spielerdaten[0]["ruestungsid"] = 0;
    }


    spielergegnerdaten[0]["leben"] = Gegner.leben;
    spielergegnerdaten[0]["erfahrung"] = Gegner.erfahrungdb;
    if (Gegner.geld < 0) {
      spielergegnerdaten[0]["geld"] = 0;
    } else {
      spielergegnerdaten[0]["geld"] = Gegner.geld;
    }
    spielergegnerdaten[0]["lvl"] = Gegner.lvl;
    spielergegnerdaten[0]["angriff"] = Gegner.angriffswert;
    spielergegnerdaten[0]["verteidigung"] = Gegner.verteidigung;
    spielergegnerdaten[0]["maxleben"] = Gegner.maxleben;

    if (spielergegnerdaten[0]["leben"] == 0 && spielergegnerdaten[0]["geld"] == 0) {
      //  document.getElementById("todesermittler").href = "/tot.php";
      spielergegnerdaten[0]["leben"] = 3;
      spielergegnerdaten[0]["erfahrung"] = 0;
      spielergegnerdaten[0]["geld"] = 6;
      spielergegnerdaten[0]["lvl"] = 1;
      spielergegnerdaten[0]["angriff"] = 1;
      spielergegnerdaten[0]["verteidigung"] = 0;
      spielergegnerdaten[0]["maxleben"] = 3;
      spielergegnerdaten[0]["waffenid"] = 0;
      spielergegnerdaten[0]["ruestungsid"] = 0;
    }
    const spielerdatennachkampf = JSON.stringify(spielerdaten);
    const spielergegnerdatennachkampf = JSON.stringify(spielergegnerdaten);

    KampfergebnisseSenden(spielerdatennachkampf, spielergegnerdatennachkampf);
  }



  // Annahme in Funktion prüfen
  // Spieler und Gegner für den Kampf sperren
  function SpielerSperren() {
    const spielerdaten = <?php json_encode($newClass->JSONStringSpieler($connection, $_SESSION["Spieler"]), JSON_UNESCAPED_SLASHES); ?>;
    const spielergegnerdaten = <?php json_encode($newClass->JSONStringGegner($connection, $_POST["spielergegner"]), JSON_UNESCAPED_SLASHES); ?>;
    const spielersperre = JSON.stringify(spielerdaten);
    const spielergegnersperre = JSON.stringify(spielergegnerdaten);

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "pve.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("spielersperren=" + spielersperre + "&spielergegnersperren=" + spielergegnersperre + "");
  }

  // Annahme in Funktion prüfen
  //Für die Rückgabe nach dem Kampf  
  function KampfergebnisseSenden(spielerdatennachkampf, spielergegnerdatennachkampf) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "pvp.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("spielerdaten=" + spielerdatennachkampf + "&spielergegnerdaten=" + spielergegnerdatennachkampf + "");
  }


  //Kampfergebnisse loggen
  function KampfergebnisseLoggen(gewinner, verlierer, verdienst, verlust, erfahrung) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "pve.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("gewinner=" + gewinner + "&verlierer=" + verlierer + "&verdienst=" + verdienst + "&verlust=" + verlust + "&erfahrung=" + erfahrung + "");
  }

  //LvL loggen
  function KampfergebnisseLoggenLvLUp(gewinner, lvl) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "pvp.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("gewinner=" + gewinner + "&lvl=" + lvl + "");
  }

  //Kampf verloren Benachrichtigung
  function KampfBenachrichtigung(gewinner, verlierer, verdienst, verlust, erfahrung) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "funktionen.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("benachrichtigung=true&gewinner=" + gewinner + "&verlierer=" + verlierer + "&verdienst=" + verdienst + "&verlust=" + verlust + "&erfahrung=" + erfahrung + "");
  }
</script>

</html>