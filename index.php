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
      <form action="/rpg.php" method="POST">
        <label>Benutzername : <input type="text" id="bname" name="bname"></label><br>
        <label>Passwort : <input type="password" id="pname" name="pw"></label><br>
        <div class="LoginButtons">
          <input name="action" value="Einloggen" type="image" src="/Bilder/HolzTextButtonEinloggen.png">
          <button type="reset" value="Zurücksetzen" style="border: 0; background: transparent"><img src="/Bilder/HolzTextButtonEntfernen.png"></button>
        </div>
      </form>
    </div>

    <div class="RegistrierungsContainer">
      <a href="/register.php"><img src="Bilder/HolzTextButtonRegistrieren.png" /></a>
    </div>

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

  </div>
  <footer>
    <p>© 2020 PropanBen. Alle Rechte vorbehalten.</p>
  </footer>

</body>

</html>