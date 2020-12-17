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
                <label>E-Mail Adresse :</label>
                <input type="text" id="email" name="email" pattern="[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" title="Beispiel example@example.com" required><br>
                <label>Benutzername :</label>
                <input type="text" id="bname" name="bname" pattern="[a-zA-Z]{3,16}" title="3 bis 16 Zeichen" required><br>
                <label>Passwort : </label>
                <input type="password" id="pname" name="pw" pattern="(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}" title="min 2 Zeichen,Buchstaben,min 1 Sonderzeichen, min 8 Zeichen" required><br>
                <label id="fehler"></label>
                <div class="LoginButtons">
                    <button type="submit" name="action" value="Registrieren" style="border: 0; background: transparent"><img src="/Bilder/HolzTextButtonRegistrieren.png"></button>
                    <button type="reset" value="Zurücksetzen" style="border: 0; background: transparent"><img src="/Bilder/HolzTextButtonEntfernen.png"></button>
                </div>
            </form>
        </div>
        <div class="Zurückbutton">
            <a href="/index.php"><img src="Bilder/Zurückbutton.png" /></a>
        </div>
    </div>
    <footer>
        <p>© 2020 PropanBen. Alle Rechte vorbehalten.</p>
    </footer>

    <script>
        let email = document.getElementById("email");
        let benutzername = document.getElementById("bname");
        let fehler = document.getElementById("fehler");
        email.addEventListener('input', EmailVorhanden);
        benutzername.addEventListener('input', BenutzerVorhanden);


        function BenutzerVorhanden() {

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1)
                        document.getElementById("fehler").innerHTML = "Bereits vorhanden";
                    else document.getElementById("fehler").innerHTML = "";

                }
            }
            xhttp.open("POST", "funktionen.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("benutzername=" + benutzername.value + "");
        }

        function EmailVorhanden() {

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        document.getElementById("fehler").innerHTML = "Bereits vorhanden";
                    } else {
                        document.getElementById("fehler").innerHTML = "";
                    }
                }
            }
            xhttp.open("POST", "funktionen.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("email=" + email.value + "");
        }
    </script>


</body>

</html>