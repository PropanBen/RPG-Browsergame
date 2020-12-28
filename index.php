<?php
session_start();
if (isset($_SESSION["Erfolg"])) {
  $_SESSION["Erfolg"] = null;
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Propania</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="rpgstyle.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>
  <div class="Hintergrund"></div>
  <div class="Inhalt">
    <div class="Logo">
      <img src="Bilder/Propania.png" />
    </div>

    <div class="LoginContainer">
      <form action="/login.php" method="POST">
        <label>Benutzername : </label><br>
        <input type="text" id="bname" name="bname" required><br>
        <label>Passwort : </label><br>
        <input type="password" id="pname" name="pw" required><br>
        <div class="LoginButtons">
          <button type="submit" name="action" value="Einloggen" style="border: 0; background: transparent" onclick="PlaySound();"><img src="/Bilder/HolzTextButtonEinloggen.png"></button>
          <button type="reset" value="Zurücksetzen" style="border: 0; background: transparent" onclick="PlaySound();"><img src="/Bilder/HolzTextButtonEntfernen.png"></button>
          <a href="/passwortvergessen.php" title="Passwort vergessen" onclick="PlaySound();">Passwort vergessen</a>
          <p style="margin-top:10px">Support: E-Mail
            <a href="mailto:info@propanben.de"><img src="/Bilder/Email.png" width=50 height=25></a></p>
        </div>
      </form>
    </div>

    <div class="RegistrierungsContainer">
      <a href="/register.php" onclick="PlaySound();"><img src="Bilder/HolzTextButtonRegistrieren.png" /></a>
    </div>
    <div class="Platzhalter"></div>
    <a id="paypal" href="https://paypal.me/PropanBen" onclick="PlaySound();"><img src="/Bilder/paypal.png"></a>

    <div class="Spielbeschreibung">
      <p>Herzlich willkommen zu Propania ! <br>
        Propania ist ein eigens von PropanBen entwickeltes Browsergame.
        Das Spiel siedelt sich im Genre Rollenspiel an. <br>
        Nach der Registrierung startet der Spieler mit seinem eigenen Avatar.
        Du hast dann die Möglichkeit dir ein eigenes Avatarbild hochzuladen.
        Der Spieler startet mit 3 Leben und 1 Angriff. In Propania gibt es
        3 verschiedene Tätigkeiten.<br><br>
        1. Ausrüstung im Marktplatz kaufen <br>
        2. Andere Spieler zum Kampf herausfordern<br>
        3. NPC Gegner zum Kampf herausfordern <br><br>

        Durch besiegen von Gegner erhält der Spieler Erfahrungspunkte und Geld.
        Wenn der Spieler genügend Erfahrungspunkte gesammelt hat steigt dieser um 1 Level auf.
        Mit einem Level Aufstieg erhöht sich das maximale Leben um 3 und der Angriff um 1 Wert.
        Das verdiente Geld kann der Spieler im Marktplatz gegen Heiltränke, Permanenttränke oder
        Waffen und Rüstungen ausgeben.
      </p>
    </div>
    <div class="Platzhalter"></div>
  </div>
  <footer>
    <p>© 2020 PropanBen. Alle Rechte vorbehalten. <a href="/impressum.php">Impressum</a> <a href="/datenschutz.php">Datenschutz</a></p>
  </footer>

</body>

<script>
  function PlaySound() {
    var audio = new Audio('/Audio/tap.wav');
    audio.play();
  }
</script>

</html>