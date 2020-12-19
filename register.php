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
                <label>E-Mail Adresse :</label>
                <input type="text" id="email" name="email" title="Beispiel example@example.com" required><br>
                <label>Benutzername :</label>
                <input type="text" id="bname" name="bname" title="3 bis 16 Zeichen" required><br>
                <label>Passwort : </label>
                <input type="password" id="pname" name="pw" pattern="(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}" title="min 8 Zeichen,Buchstaben,Zahlen,min 1 Sonderzeichen" required><br>
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
        let passwort = document.getElementById("pname");
        let fehler = document.getElementById("fehler");
        email.addEventListener('input', EmailVorhanden);
        benutzername.addEventListener('input', BenutzerVorhanden);
        passwort.addEventListener('input', PasswortValidieren);


        function BenutzerVorhanden() {

            const regex = RegExp("[a-zA-Z]{3,16}");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        fehler.innerHTML = "Bereits vorhanden";
                        benutzername.classList.remove('inputvalid');
                        benutzername.classList.add('inputinvalid');
                    } else if (regex.test(benutzername.value)) {
                        benutzername.classList.remove('inputinvalid');
                        benutzername.classList.add('inputvalid');
                    } else {
                        fehler.innerHTML = "";
                        benutzername.classList.remove('inputvalid');
                        benutzername.classList.add('inputinvalid');
                    }

                }
            }
            xhttp.open("POST", "login.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("benutzername=" + benutzername.value + "");
        }

        function EmailVorhanden() {

            const regex = RegExp("(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}");
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        fehler.innerHTML = "Bereits vorhanden";
                        email.classList.remove('inputvalid');
                        email.classList.add('inputinvalid');
                    } else if (regex.test(email.value)) {
                        email.classList.remove('inputinvalid');
                        email.classList.add('inputvalid');
                    } else {
                        fehler.innerHTML = "";
                        email.classList.remove('inputvalid');
                        email.classList.add('inputinvalid');
                    }
                }
            }
            xhttp.open("POST", "login.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("email=" + email.value + "");
        }

        function PasswortValidieren() {
            const regex = RegExp("(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}");
            if (regex.test(passwort.value)) {
                passwort.classList.remove('inputinvalid');
                passwort.classList.add('inputvalid');
            } else {
                fehler.innerHTML = "";
                passwort.classList.remove('inputvalid');
                passwort.classList.add('inputinvalid');
            }
        }
    </script>


</body>

</html>