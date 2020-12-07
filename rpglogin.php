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
  </div>
  <footer>
    <p>© 2020 PropanBen. Alle Rechte vorbehalten.</p>
  </footer>

</body>

</html>