<?php
session_start();


if (!isset($_SESSION["Erfolg"])) {
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
                <label>Passwort : </label><br>
                <input type="password" id="pname" name="pw" pattern="(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}" title="min 8 Zeichen,Buchstaben,Zahlen,min 1 Sonderzeichen" required><br>
                <label>Passwort </label><br>
                <label>Wiederholen : </label><br>
                <input type="password" id="pname2" name="pw2" pattern="(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}" title="min 8 Zeichen,Buchstaben,Zahlen,min 1 Sonderzeichen" required><br>
                <p id="fehler"><?php echo $_SESSION["Erfolg"] ?></p>
                <div class="LoginButtons">
                    <button type="submit" name="token" value="<?php echo $_GET["token"]; ?>" style="border: 0; background: transparent"><img src="/Bilder/HolzTextButtonAendern.png"></button>
                    <button type="reset" style="border: 0; background: transparent"><img src="/Bilder/HolzTextButtonEntfernen.png"></button>
                </div>
        </div>

        <script>
            let passwort = document.getElementById("pname");
            let passwort2 = document.getElementById("pname2");
            let fehler = document.getElementById("fehler");
            passwort.addEventListener('input', PasswortGleichheit);
            passwort2.addEventListener('input', PasswortGleichheit);

            function PasswortGleichheit() {

                if (passwort.value !== passwort2.value) {
                    fehler.innerHTML = "Ungleich";
                } else {
                    fehler.innerHTML = "";
                }
            }
        </script>
</body>

</html>