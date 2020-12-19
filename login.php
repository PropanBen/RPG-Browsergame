<?php
session_start();
include("dbconnect.php");


// Prüft beim Registrieren ob Benutzername vorhanden, JS Eingabe
if (isset($_POST["benutzername"])) {

    $select = $connection->prepare("SELECT benutzername FROM konto WHERE benutzername = ? ");
    $select->bind_param("s", $_POST["benutzername"]);
    $select->execute();
    $result = $select->get_result();
    $row = mysqli_fetch_row($result);
    if ($result->num_rows == 1) {
        echo 1;
    }
}
// Prüft beim Registrieren ob email vorhanden, JS Eingabe
if (isset($_POST["email"])) {

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
    $_SESSION = array();
    $_SESSION["Spieler"] = null;
    session_destroy();
    header('location: index.php');
    die();
}

// Einloggen---------------------------------------------------------------------------------------------
if (!isset($_SESSION["Spieler"])) {
    if (isset($_POST["action"]) && $_POST["action"] == "Einloggen") {
        $player = $_POST["bname"];
        $passwort = $_POST["pw"];
        $login = $connection->prepare("SELECT benutzername, passwort FROM konto WHERE benutzername = ?");
        $login->bind_param("s", $player);
        $login->execute();
        $result = $login->get_result();
        $row = mysqli_fetch_row($result);
        if (
            preg_match("^[a-zA-Z]{3,16}^", $player)
            && preg_match("^(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}^", $passwort)
            && $player == $row[0] && password_verify($passwort, $row[1])
        ) {
            $_SESSION["Spieler"] = $player;
            // Spieler entsperren
            $sperre = 0;
            $update = $connection->prepare("UPDATE spieler SET gesperrt=? WHERE spielername=?");
            $update->bind_param("is", $sperre, $player);
            $update->execute();
            $update->close();
            //Logging
            $ereignis = "Eingeloggt";
            $insert = $connection->prepare("INSERT INTO `log` (ereignis, spieler) VALUES (?,?)");
            $insert->bind_param("ss", $ereignis, $player);
            $insert->execute();
            $insert->close();
            header('location: rpg.php');
        } else {
            header('location: index.php');
        }
        $login->close();
    }
}

// Registrieren---------------------------------------------------------------------------------------------

if (isset($_POST["action"]) && $_POST["action"] == "Registrieren") {
    $passworthash = password_hash($_POST["pw"], PASSWORD_DEFAULT);
    $select = $connection->prepare("SELECT benutzername, email FROM konto WHERE benutzername = ? OR email = ? ");
    $select->bind_param("ss", $_POST["bname"], $_POST["email"]);
    $select->execute();
    $result = $select->get_result();
    if (
        $result->num_rows == 0 &&
        preg_match("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^", $_POST["email"])
        && preg_match("^[a-zA-Z]{3,16}^", $_POST["bname"]) &&
        preg_match("^(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}^", $_POST["pw"])
    ) {
        // Konto anlegen
        $insert = $connection->prepare("INSERT INTO konto (benutzername, passwort,email) VALUES (?,?,?)");
        $insert->bind_param("sss", $_POST["bname"], $passworthash, $_POST["email"]);
        $insert->execute();
        $insert->close();
        //Spieler anlegen
        $insertspieler = $connection->prepare("INSERT INTO spieler (spielername, lvl, erfahrung, 
		geld,leben,maxleben, angriff, waffenid, ruestungsid, spielerbildpfad, rechte,gesperrt) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $insertspieler->bind_param("siiiiiiiissi", $player, $lvl, $erfahrung, $geld, $leben, $maxleben, $angriff, $leer, $leer, $pfad, $rechte, $sperre);
        $player = $_POST["bname"];
        $lvl = 1;
        $erfahrung = 0;
        $geld = 0;
        $leben = 3;
        $maxleben = 3;
        $angriff = 1;
        $leer = 0;
        $pfad = "/Spieleravatare/Default.png";
        $rechte = "Spieler";
        $sperre = 0;
        $insertspieler->execute();
        $insertspieler->close();
        $_SESSION["Spieler"] = $_POST["bname"];

        //Logging
        $ereignis = "Registriert";
        $insert = $connection->prepare("INSERT INTO `log` (ereignis, spieler) VALUES (?,?)");
        $insert->bind_param("ss", $ereignis, $player);
        $insert->execute();
        $insert->close();
        header('location: rpg.php');
    } else {
        //Userausgabe Benutzer bereits vorhanden 
        echo "Benutzer bereits vorhanden";
        header('location: register.php');
    };
}

// Passwort ändern
if (isset($_POST["pw"]) && isset($_POST["pw2"])) {

    if (
        preg_match("^(?=(.*\d){1})(?=.*[a-zA-Z])(?=.*[!@#$%])[0-9a-zA-Z!@#$%]{8,}^", $_POST["pw"]) &&
        $_POST["pw"] == $_POST["pw2"]
    ) {

        $passworthash = password_hash($_POST["pw"], PASSWORD_DEFAULT);

        $update = $connection->prepare("UPDATE konto SET passwort=? WHERE benutzername=?");
        $update->bind_param("ss", $passworthash, $_SESSION["Spieler"]);
        $update->execute();
        $update->close();
        echo 1;
        //  header('location: einstellungen.php');
    }
}
