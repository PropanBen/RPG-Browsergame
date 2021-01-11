<?php
session_start();
include("dbconnect.php");

$newLoginClass = new DBLoginAktionen();


// Namensänderung
if (isset($_POST["action"]) && $_POST["action"] === "nameaendern" && isset($_POST["neuername"])) {

    $select2 = $connection->prepare("SELECT benutzername FROM konto WHERE benutzername = ? ");
    $select2->bind_param("s", $_POST["neuername"]);
    $select2->execute();
    $result2 = $select2->get_result();
    $row2 = $result2->fetch_assoc();

    if ($row2["benutzername"] !== $_POST["neuername"]) {
        $select = $connection->prepare("SELECT id FROM konto WHERE benutzername = ? ");
        $select->bind_param("s", $_SESSION["Spieler"]);
        $select->execute();
        $result = $select->get_result();
        $row = $result->fetch_assoc();

        $select2 = $connection->prepare("SELECT benutzername FROM konto WHERE benutzername = ? ");
        $select2->bind_param("s", $_POST["neuername"]);
        $select2->execute();
        $result2 = $select2->get_result();
        $row2 = $result2->fetch_assoc();

        if ($result->num_rows == 1 && preg_match("^[a-zA-Z]{3,16}^", $_POST["neuername"])) {
            $update = $connection->prepare("UPDATE spieler SET spielername=? WHERE kontoid=?");
            $update->bind_param("ss", $_POST["neuername"], $row["id"]);
            $update->execute();
            $update->close();

            $update = $connection->prepare("UPDATE konto SET benutzername=? WHERE id=?");
            $update->bind_param("ss", $_POST["neuername"], $row["id"]);
            $update->execute();
            $update->close();
            $_SESSION["Erfolgname"] = "Geaendert";
            $_SESSION["Spieler"] = $_POST["neuername"];
            header('location: einstellungen.php');
        } else {

            $_SESSION["Erfolgname"] = "Bereits vorhanden";
            $_SESSION["Erfolg"] = "negativ";
            header('location: einstellungen.php');
        }
    } else {
        $_SESSION["Erfolgname"] = "Bereits vorhanden";
        header('location: einstellungen.php');
    }
}


// Prüft beim Registrieren ob Benutzername vorhanden, JS Eingabe
if (isset($_POST["Registrieren"]) && isset($_POST["benutzername"])) {

    $select = $connection->prepare("SELECT benutzername FROM konto WHERE benutzername = ? ");
    $select->bind_param("s", $_POST["benutzername"]);
    $select->execute();
    $result = $select->get_result();
    $row = mysqli_fetch_row($result);
    if ($result->num_rows == 1) {
        echo 1;
    } else echo 0;
}
// Prüft beim Registrieren ob email vorhanden, JS Eingabe
if (isset($_POST["Registrieren"]) && isset($_POST["email"])) {

    $select = $connection->prepare("SELECT email FROM konto WHERE email = ? ");
    $select->bind_param("s", $_POST["email"]);
    $select->execute();
    $result = $select->get_result();
    $row = mysqli_fetch_row($result);
    if ($result->num_rows == 1) {
        echo 1;
    }
}

// Ausloggen ---------------------------------------------------------------------------------------------

if (isset($_POST["action"]) && $_POST["action"] === "Ausloggen") {
    $newLoginClass->Logging($connection, "Ausgeloggt");
    $_SESSION = array();
    $_SESSION["Spieler"] = null;
    session_destroy();
    header('location: index.php');
    die();
}

// Einloggen---------------------------------------------------------------------------------------------

if (isset($_POST["action"]) && $_POST["action"] == "Einloggen") {
    echo "Vor Passwortprüfung";
    $player = $_POST["bname"];
    $passwort = $_POST["pw"];
    $login = $connection->prepare("SELECT benutzername, passwort FROM konto WHERE benutzername = ?");
    $login->bind_param("s", $player);
    $login->execute();
    $result = $login->get_result();
    $row = mysqli_fetch_row($result);
    if (
        preg_match("^[a-zA-Z]{3,16}^", $player)
        && preg_match("^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}^", $passwort)
        && $player == $row[0] && password_verify($passwort, $row[1])
    ) {
        $select = $connection->prepare("SELECT id FROM konto WHERE benutzername = ? ");
        $select->bind_param("s", $player);
        $select->execute();
        $result2 = $select->get_result();
        $row2 = $result2->fetch_assoc();

        $_SESSION["id"] = $row2["id"];
        $_SESSION["Spieler"] = $player;
        $_SESSION["Spielerid"] = $newLoginClass->SpielerIDErmitteln($connection, $row2["id"]);
        // Spieler entsperren
        $sperre = 0;
        $update = $connection->prepare("UPDATE spieler SET gesperrt=? WHERE spielername=?");
        $update->bind_param("is", $sperre, $player);
        $update->execute();
        $update->close();
        //Logging
        $newLoginClass->Logging($connection, "Eingeloggt");
        header('location: rpg.php');
    } else {
        header('location: index.php');
    }
    $login->close();
}


// Registrieren---------------------------------------------------------------------------------------------

if (isset($_POST["action"]) && $_POST["action"] == "Registrieren" && isset($_POST["bname"]) && isset($_POST["email"]) && isset($_POST["pw"])) {
    $passworthash = password_hash($_POST["pw"], PASSWORD_DEFAULT);
    $select = $connection->prepare("SELECT benutzername, email FROM konto WHERE benutzername = ? OR email = ? ");
    $select->bind_param("ss", $_POST["bname"], $_POST["email"]);
    $select->execute();
    $result = $select->get_result();
    if (
        $result->num_rows == 0 &&
        preg_match("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^", $_POST["email"])
        && preg_match("^[a-zA-Z]{3,16}^", $_POST["bname"]) &&
        preg_match("^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}^", $_POST["pw"])
    ) {
        // Konto anlegen
        $insert = $connection->prepare("INSERT INTO konto (benutzername, passwort,email) VALUES (?,?,?)");
        $insert->bind_param("sss", $_POST["bname"], $passworthash, $_POST["email"]);
        $insert->execute();
        $insert->close();

        $select = $connection->prepare("SELECT id FROM konto WHERE benutzername = ? ");
        $select->bind_param("s", $_POST["bname"]);
        $select->execute();
        $result = $select->get_result();
        $row = $result->fetch_assoc();

        $_SESSION["id"] = $row["id"];

        //Spieler anlegen
        $insertspieler = $connection->prepare("INSERT INTO spieler (kontoid,spielername, lvl, erfahrung, 
		geld,leben,maxleben, angriff,verteidigung, waffenid, ruestungsid, spielerbildpfad, rechte,gesperrt) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $insertspieler->bind_param("isiiiiiiiiissi", $row["id"], $player, $lvl, $erfahrung, $geld, $leben, $maxleben, $angriff, $verteidigung, $leer, $leer, $pfad, $rechte, $sperre);
        $player = $_POST["bname"];
        $lvl = 1;
        $erfahrung = 0;
        $geld = 6;
        $leben = 3;
        $maxleben = 3;
        $angriff = 1;
        $verteidigung = 0;
        $leer = 0;
        $pfad = "/Spieleravatare/Default.png";
        $rechte = "Spieler";
        $sperre = 0;
        $insertspieler->execute();
        $insertspieler->close();
        $_SESSION["Spieler"] = $_POST["bname"];
        $_SESSION["Spielerid"] = $newLoginClass->SpielerIDErmitteln($connection, $row["id"]);

        //Invetar erstellen
        $newLoginClass->InventarErstellen($connection, $_SESSION["Spielerid"]);

        // Email versenden
        $recipient = $_POST["email"];
        $subject = 'Propania Registrierung';
        $sender = 'noreply@propanben.de';
        $content =
            'Willkommen in Propania,<br>
             Vielen Herzlichen Dank für die Registrierung bei Propania.<br>
 
             Jetz einloggen unter:<br><br>
             https://propania.propanben.de <br><br>

             Ich wünsche dir viel Spaß und viel Erfolg beim spielen.<br><br>

             Viele Grüße<br>
             Euer PropanBen<br>
            ';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        mail($recipient, $subject, $content, $headers, ' -f ' . $sender);
        $subject = "Neuer Spieler " . $_SESSION["Spieler"] . " hat sich registriert !";
        mail("info@propanben.de", $subject, "", $headers, $sender);

        // Nachricht an alle Senden
        $nachrichtentext = "Neuer Spieler " . $_SESSION["Spieler"] . " hat sich registriert !";
        $newLoginClass->NachrichtenAnnehmen($connection, "alle", $nachrichtentext, $_SESSION["Spieler"]);

        //Logging
        $newLoginClass->Logging($connection, "Registriert");
        header('location: rpg.php');
    } else {
        //Userausgabe Benutzer bereits vorhanden 
        echo "Benutzer bereits vorhanden";
        header('location: register.php');
    };
}

// Passwort ändern
if (isset($_POST["action"]) && $_POST["action"] === "pwaendern" && isset($_POST["pw"]) && isset($_POST["pw2"])) {

    if (
        preg_match("^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}^", $_POST["pw"]) &&
        $_POST["pw"] == $_POST["pw2"]
    ) {

        $passworthash = password_hash($_POST["pw"], PASSWORD_DEFAULT);

        $update = $connection->prepare("UPDATE konto SET passwort=? WHERE id=?");
        $update->bind_param("ss", $passworthash, $_SESSION["id"]);
        $update->execute();
        $update->close();
        //Logging
        $newLoginClass->Logging($connection, "Passwortänderung");
        $_SESSION["Erfolgpw"] = "Geändert";
        header('location: einstellungen.php');
    }
}

// Passwort vergessen
if (isset($_POST["action"]) && $_POST["action"] === "vergessen" && isset($_POST["email"])) {

    if (preg_match("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^", $_POST["email"])) {

        $select = $connection->prepare("SELECT email FROM konto WHERE email = ?");
        $select->bind_param("s", $_POST["email"]);
        $select->execute();
        $result = $select->get_result();
        if ($result->num_rows == 1) {

            // Zufälligen Token generieren
            $token = openssl_random_pseudo_bytes(16);
            $token = bin2hex($token);

            $update = $connection->prepare("UPDATE konto SET token=? WHERE email=?");
            $update->bind_param("ss", $token, $_POST["email"]);
            $update->execute();
            $update->close();

            // Email versenden
            $recipient = $_POST["email"];
            $subject = 'Propania Passwort zurücksetzen';
            $url = "https://propania.propanben.de/passwortzuruecksetzen.php?token=" . $token;
            $sender = 'noreply@propanben.de';
            $content =
                'Lieber Spieler, liebe Spielerin von Propania,<br>
             du möchtest dein Passwort zurücksetzen.<br>
             Klicke bitte dazu auf nachfolgenden Link und gib dein neues Passwort ein !<br><br>
             ' . $url . '<br><br>
             Vielen Dank und weiterhin viel Spaß in in Propania     
            ';

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            mail($recipient, $subject, $content, $headers, ' -f ' . $sender);
            //Logging
            $newLoginClass->Logging($connection, "Passwort Wiederherstellung beantragt");
            header('location: passwortvergessen.php');
            $_SESSION["Erfolg"] = "E-Mail Verschickt";
        }
    }
}

// Passwort ändern Spieler mit Token
if (isset($_POST["token"]) && isset($_POST["pw"]) && isset($_POST["pw2"])) {

    $select = $connection->prepare("SELECT token FROM konto WHERE token = ?");
    $select->bind_param("s", $_POST["token"]);
    $select->execute();
    $result = $select->get_result();
    if ($result->num_rows == 1) {

        if (
            preg_match("^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}^", $_POST["pw"]) &&
            $_POST["pw"] == $_POST["pw2"]
        ) {

            $passworthash = password_hash($_POST["pw"], PASSWORD_DEFAULT);

            $leer = "";
            $update = $connection->prepare("UPDATE konto SET passwort=?,token=? WHERE token=?");
            $update->bind_param("sss", $passworthash, $leer, $_POST["token"]);
            $update->execute();
            $update->close();
            //Logging
            $newLoginClass->Logging($connection, "Passwort durch E-Mail geändert");
            header('location: passwortzureucksetzen.php');
            $_SESSION["Erfolg"] = "Passwort geändert";
        }
    }
}

// Konto löschen
if (isset($_POST["konto"]) && $_POST["konto"] === "loeschen") {


    // Invetar + Slots löschen
    $newLoginClass->Inventarloeschen($connection, $_SESSION["Spielerid"]);

    // Erst FK Tabelle löschen
    $delete = $connection->prepare("DELETE from spieler WHERE spielername =?");
    $delete->bind_param("s", $_SESSION["Spieler"]);
    $delete->execute();
    $delete->close();

    $delete = $connection->prepare("DELETE from konto WHERE id =?");
    $delete->bind_param("s", $_SESSION["id"]);
    $delete->execute();
    $delete->close();

    $newLoginClass->Logging($connection, "Konto gelöscht");

    $_SESSION = array();
    $_SESSION["Spieler"] = null;
    session_destroy();
    header('location: index.php');
    die();
}

class DBLoginAktionen
{

    // Logging
    function Logging($connection, $ereignis)
    {
        $insert = $connection->prepare("INSERT INTO `log` (ereignis, spieler) VALUES (?,?)");
        $insert->bind_param("ss", $ereignis, $_SESSION["Spieler"]);
        $insert->execute();
        $insert->close();
    }

    // spielerid ermitteln
    function SpielerIDErmitteln($connection, $id)
    {
        $select = $connection->prepare("SELECT id FROM spieler WHERE kontoid = ? ");
        $select->bind_param("s", $id);
        $select->execute();
        $result = $select->get_result();
        $row = $result->fetch_assoc();
        return $row["id"];
    }
    // Nachrichten Senden
    function NachrichtenAnnehmen($connection, $id, $nachrichtentext, $absender)
    {
        if ($id === "alle") {
            $select = $connection->prepare("SELECT id FROM spieler");
            $select->execute();
            $result = $select->get_result();
            while ($row = $result->fetch_array()) {
                $id = $row['id'];
                $insert = $connection->prepare("INSERT INTO `nachrichten` (spielerid,nachrichtentext,absender) VALUES (?,?,?)");
                $insert->bind_param("iss", $id, $nachrichtentext, $absender);
                $insert->execute();
                $insert->close();
            }
        } else {
            $insert = $connection->prepare("INSERT INTO `nachrichten` (spielerid,nachrichtentext,absender) VALUES (?,?,?)");
            $insert->bind_param("sss", $id, $nachrichtentext, $absender);
            $insert->execute();
            $insert->close();
        }
    }

    // Inventar erstellen
    function InventarErstellen($connection, $spielerid)
    {
        $anzahl = 0;
        $slot = 0;
        $insert = $connection->prepare("INSERT INTO inventar (spielerid,slot1,slot2,slot3,slot4,slot5,slotanzahl) VALUES (?,?,?,?,?,?,?)");
        $insert->bind_param("ii", $spielerid, $slot, $slot, $slot, $slot, $slot, $anzahl);
        $insert->execute();
        $insert->close();

        $select = $connection->prepare("SELECT id FROM inventar WHERE spielerid = ? ");
        $select->bind_param("i", $spielerid);
        $select->execute();
        $result = $select->get_result();
        $row = $result->fetch_assoc();

        $update = $connection->prepare("UPDATE spieler SET inventarid=? WHERE id=?");
        $update->bind_param("id", $row["id"], $spielerid);
        $update->execute();
        $update->close();
        $select->close();
    }

    // Inventar löschen
    function InventarLoeschen($connection, $spielerid)
    {
        $select = $connection->prepare("SELECT inventarid FROM spieler WHERE id = ? ");
        $select->bind_param("i", $spielerid);
        $select->execute();
        $result = $select->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            $this->SlotsLoeschen($connection, $row["inventarid"]);
        }

        $delete = $connection->prepare("DELETE from inventar WHERE spielerid =?");
        $delete->bind_param("i", $spielerid);
        $delete->execute();
        $delete->close();
    }
    // Slots löschen
    function SlotsLoeschen($connection, $inventarid)
    {
        $delete = $connection->prepare("DELETE from slot WHERE inventarid =?");
        $delete->bind_param("i", $inventarid);
        $delete->execute();
        $delete->close();
    }
}
