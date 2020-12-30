<?php
session_start();
include("dbconnect.php");

$newClass = new DBAktionen();

if (!isset($_SESSION["Spieler"])) {
	header('location: index.php');
}

// PVP Kampf Benachrichtigung
if (isset($_POST["benachrichtigung"])) {

	$verliererid = $newClass->SpielerIDNameLesen($connection, $_POST["verlierer"]);
	$gewinnerid = $newClass->SpielerIDNameLesen($connection, $_POST["gewinner"]);
	$nachrichtentext = "Du hast gegen mich im PVP verloren. Ich erbeute " . $_POST["verdienst"] . " Geld und " . $_POST["erfahrung"] . " EXP von dir";
	$nachrichtentext2 = "Du hast gegen " . $_POST["verlierer"] . " im PVP gewonnen und gewinnst " . $_POST["verlust"] . " Geld und " . $_POST["erfahrung"] . " EXP";
	$newClass->NachrichtenAnnehmen($connection, $verliererid, $nachrichtentext, $_POST["gewinner"]);
	$newClass->NachrichtenAnnehmen($connection, $gewinnerid, $nachrichtentext2, $_POST["verlierer"]);
}

// Nachricht löschen

if (isset($_POST["nachrichtloeschen"]) && isset($_POST["id"])) {
	$newClass->NachrichtLoeschen($connection, $_POST["id"]);
}

// Alle Nachrichten löschen
{
	if (isset($_POST["allenachrichtenloeschen"])) {
		$newClass->AlleNachrichtLoeschen($connection);
	}
}

//Nachrichten annehmen

if (isset($_POST["id"]) && isset($_POST["nachrichtentext"]) && isset($_POST["absender"])) {
	$newClass->NachrichtenAnnehmen($connection, $_POST["id"], $_POST["nachrichtentext"], $_POST["absender"]);
	if ($_POST["id"] != "alle")
		$newClass->NachrichtenAnnehmen($connection, $_SESSION["Spielerid"], $_POST["nachrichtentext"], "an " . $newClass->SpielernameIDLesen($connection, $_POST["id"]));
}

//Bild hochladen
if (isset($_FILES["bildhochladen"]) && $_FILES["bildhochladen"]["size"] > 0) {
	$uploaddir = './Spieleravatare/';
	$filename = $_SESSION["Spieler"];
	$filename = str_replace(" ", "", $filename);
	$fileextension = ".png";
	move_uploaded_file($_FILES["bildhochladen"]['tmp_name'], $uploaddir . $filename . $fileextension);

	$newClass->Bildaendern($connection, "/Spieleravatare/" . $filename . $fileextension, $_SESSION["Spieler"]);
	// Logging
	$newClass->Logging($connection, 'Bild ' . $filename . $fileextension . ' hochgeladen');
	header('location: einstellungen.php');
}

//Bild löschen  ---------------------------------------------------------------------------------------------
if (isset($_POST["bildloeschen"])) {
	$file = "./Spieleravatare/" . $_SESSION["Spieler"] . ".png";
	if (file_exists($file)) {
		unlink($file);
	}
	$newClass->Bildaendern($connection, "/Spieleravatare/Default.png", $_SESSION["Spieler"]);
	header('location: rpg.php');
}

//Redirekt wenn kein Bild ausgewählt  ---------------------------------------------------------------------------------------------
if (isset($_FILES["bildhochladen"]) && $_FILES["bildhochladen"]["size"] == 0) {
	header('location: rpg.php');
}

//Waffe kaufen  ---------------------------------------------------------------------------------------------
if (isset($_POST["waffenid"])) {
	$newClass->Kaufen($connection, "waffen", "waffenid", $_POST["waffenid"]);
}

//Rüstung kaufen  ---------------------------------------------------------------------------------------------
if (isset($_POST["ruestungsid"])) {
	$newClass->Kaufen($connection, "ruestung", "ruestungsid", $_POST["ruestungsid"]);
}

//Trank kaufen
if (isset($_POST["trankid"])) {
	$newClass->TränkeKaufen($connection, $_POST["trankid"]);
}

//Spieler und Gegner sperren PvE
if (isset($_POST["spielersperren"]) && isset($_POST["gegnersperren"])) {
	$spieler = (json_decode($_POST["spielersperren"], true));
	$gegner = (json_decode($_POST["gegnersperren"], true));
	$spielername = json_encode($spieler[0]["spielername"]);
	$spielername = str_replace('"', "", $spielername);
	$gegnerid =  json_encode($gegner[0]["gegnerid"]);
	$sperre = 1;
	//Spieler und Gegner sperren
	$newClass->Spielersperren($connection, $sperre, $spielername);
	$newClass->Gegnersperren($connection, $sperre, $gegnerid);
}

//Spieler und SpielerGegner sperren PVP
if (isset($_POST["spielersperren"]) && isset($_POST["spielergegnersperren"])) {
	$spieler = (json_decode($_POST["spielersperren"], true));
	$spielergegner  = (json_decode($_POST["spielergegnersperren"], true));
	$spielername = json_encode($spieler[0]["spielername"]);
	$spielergegnername = json_encode($spielergegner[0]["spielername"]);
	$spielername = str_replace('"', "", $spielername);
	$spielergegnername = str_replace('"', "", $spielergegnername);
	$sperre = 1;
	//Beide Spieler sperren
	$newClass->Spielersperren($connection, $sperre, $spielername);
	$newClass->Spielersperren($connection, $sperre, $spielergegnername);
}

//Spieler und SpielerGegnerdaten nach dem Kampf annehmen PVP
if (isset($_POST["spielerdaten"]) && isset($_POST["spielergegnerdaten"])) {
	$spieler = (json_decode($_POST["spielerdaten"], true));
	$lvl = json_encode($spieler[0]["lvl"]);
	$erfahrung = json_encode($spieler[0]["erfahrung"]);
	$leben = json_encode($spieler[0]["leben"]);
	$geld = json_encode($spieler[0]["geld"]);
	$spielername = json_encode($spieler[0]["spielername"]);
	$spielername = str_replace('"', "", $spielername);
	$spielerangriff = json_encode($spieler[0]["angriff"]);
	$spielerverteidigung = json_encode($spieler[0]["verteidigung"]);
	$spielermaxleben = json_encode($spieler[0]["maxleben"]);
	$spielerwaffenid = json_encode($spieler[0]["waffenid"]);
	$spielerruestungsid = json_encode($spieler[0]["ruestungsid"]);
	$sperre = 0;
	$newClass->SpielerStatsSchreiben($connection, $lvl, $erfahrung, $geld, $leben, $spielerangriff, $spielerverteidigung, $spielermaxleben, $spielerwaffenid, $spielerruestungsid, $spielername);

	$spielergegner = (json_decode($_POST["spielergegnerdaten"], true));
	$lvl = json_encode($spielergegner[0]["lvl"]);
	$erfahrung = json_encode($spielergegner[0]["erfahrung"]);
	$leben = json_encode($spielergegner[0]["leben"]);
	$geld = json_encode($spielergegner[0]["geld"]);
	$spielergegnername = json_encode($spielergegner[0]["spielername"]);
	$spielergegnername = str_replace('"', "", $spielergegnername);
	$spielergegnerangriff = json_encode($spielergegner[0]["angriff"]);
	$spielergegnerverteidigung = json_encode($spielergegner[0]["verteidigung"]);
	$spielergegnermaxleben = json_encode($spielergegner[0]["maxleben"]);
	$spielergegnerwaffenid = json_encode($spielergegner[0]["waffenid"]);
	$spielergegnerruestungsid = json_encode($spielergegner[0]["ruestungsid"]);
	$sperre = 0;
	$newClass->SpielerStatsSchreiben($connection, $lvl, $erfahrung, $geld, $leben, $spielergegnerangriff, $spielergegnerverteidigung, $spielergegnermaxleben, $spielergegnerwaffenid, $spielergegnerruestungsid, $spielergegnername);

	// Nach Kampf entsperren
	$sperre = 0;
	$newClass->Spielersperren($connection, $sperre, $spielername);
	$newClass->Spielersperren($connection, $sperre, $spielergegnername);
}


//Spieler und Gegnerdaten nach Kampf annehmen PVE
if (isset($_POST["spielerdaten"]) && isset($_POST["gegnerdaten"])) {
	//Spieler
	$spieler = (json_decode($_POST["spielerdaten"], true));
	$lvl = json_encode($spieler[0]["lvl"]);
	$erfahrung = json_encode($spieler[0]["erfahrung"]);
	$leben = json_encode($spieler[0]["leben"]);
	$geld = json_encode($spieler[0]["geld"]);
	$spielername = json_encode($spieler[0]["spielername"]);
	$spielername = str_replace('"', "", $spielername);
	$spielerangriff = json_encode($spieler[0]["angriff"]);
	$spielerverteidigung = json_encode($spieler[0]["verteidigung"]);
	$spielermaxleben = json_encode($spieler[0]["maxleben"]);
	$spielerwaffenid = json_encode($spieler[0]["waffenid"]);
	$spielerruestungsid = json_encode($spieler[0]["ruestungsid"]);
	$sperre = 0;
	$newClass->SpielerStatsSchreiben($connection, $lvl, $erfahrung, $geld, $leben, $spielerangriff, $spielerverteidigung, $spielermaxleben, $spielerwaffenid, $spielerruestungsid, $spielername);
	if ($leben == 0 && $geld == 0) {
		$_SESSION["tot"] = true;
		header('location: tot.php');
	}

	//Gegner
	$gegner = (json_decode($_POST["gegnerdaten"], true));
	$gegnerid =  json_encode($gegner[0]["gegnerid"]);
	$gegnerleben = json_encode($gegner[0]["leben"]);
	$gegnergeld =  json_encode($gegner[0]["geld"]);
	if ($gegnerleben > 0) {
		$newClass->GegnerStatsSchreiben($connection, $gegnerleben, $gegnergeld, $gegnerid);
	} else {
		//	$newClass->Gegnerloeschen($connection, $gegnerid);
	}

	//Spieler und Gegner entsperren
	$newClass->Spielersperren($connection, $sperre, $spielername);
	$newClass->Gegnersperren($connection, $sperre, $gegnerid);
}

// admin.php ----------------------------------------------------------------------------------------------------

// Thema
if (isset($_POST["themaspeichern"])) {
	$insert = $connection->prepare("INSERT INTO themen (themenname, themenbildpfad) VALUES (?,?)");
	$insert->bind_param("ss", $thema, $themenbildpfad);
	$thema = $_POST["thema"];
	$thematrim = str_replace(" ", "", $thema);
	$themenbildpfad = "/Themenbilder/" . $thematrim  . date("Ymd") . time() . ".png";
	$insert->execute();
	$insert->close();
	$uploaddir = './Themenbilder/';
	$filename = $thema . date("Ymd") . time();
	$filename = str_replace(" ", "", $filename);
	$fileextension = ".png";
	move_uploaded_file($_FILES["themabildhochladen"]['tmp_name'], $uploaddir . $filename . $fileextension);
}
//Gegner
if (isset($_POST["gegnerhochladen"])) {
	$insert = $connection->prepare("INSERT INTO gegner (gegnername, lvl,leben,angriff,geld,gegnerbildpfad,thema,gesperrt) VALUES (?,?,?,?,?,?,?,?)");
	$insert->bind_param("siiiissi", $gegnername, $lvl, $leben, $angriff, $geld, $pfad, $thema, $sperre);
	$gegnername = $_POST["gegnername"];
	$lvl = $_POST["lvl"];
	$leben = $_POST["leben"];
	$angriff = $_POST["angriff"];
	$geld = $_POST["geld"];
	$gegnernametrim = str_replace(" ", "", $gegnername);
	$pfad = "/Gegneravatare/" . $gegnernametrim . "" . date("Ymd") . time() . ".png";
	$thema = $_POST["thema"];
	$sperre = 0;
	$insert->execute();
	$insert->close();
	$uploaddir = './Gegneravatare/';
	$filename = $gegnername . date("Ymd") . time();
	$filename = str_replace(" ", "", $filename);
	$fileextension = ".png";
	move_uploaded_file($_FILES["gegnerbildhochladen"]['tmp_name'], $uploaddir . $filename . $fileextension);
}
// Waffen
if (isset($_POST["waffenhochladen"])) {
	$insert = $connection->prepare("INSERT INTO waffen (waffenname, waffenwert,geldwert,waffenbildpfad) VALUES (?,?,?,?)");
	$insert->bind_param("siis", $waffenname, $waffenwert, $geldwert, $pfad);
	$waffenname = $_POST["waffenname"];
	$waffenwert = $_POST["waffenwert"];
	$geldwert = $_POST["waffengeldwert"];
	$waffennametrim = str_replace(" ", "", $waffenname);
	$pfad = "/Waffenbilder/" . $waffennametrim . "" . date("Ymd") . time() . ".png";
	$insert->execute();
	$insert->close();
	$uploaddir = './Waffenbilder/';
	$filename = $waffenname . date("Ymd") . time();
	$filename = str_replace(" ", "", $filename);
	$fileextension = ".png";
	move_uploaded_file($_FILES["waffenbildhochladen"]['tmp_name'], $uploaddir . $filename . $fileextension);
}
// Rüstung
if (isset($_POST["ruestunghochladen"])) {
	$insert = $connection->prepare("INSERT INTO ruestung (ruestungsname, ruestungswert,geldwert,ruestungsbildpfad) VALUES (?,?,?,?)");
	$insert->bind_param("siis", $ruestungsname, $ruestungswert, $geldwert, $pfad);
	$ruestungsname = $_POST["ruestungsname"];
	$ruestungswert = $_POST["ruestungswert"];
	$geldwert = $_POST["ruestungsgeldwert"];
	$ruestungsnametrim = str_replace(" ", "", $ruestungsname);
	$pfad = "/Ruestungsbilder/" . $ruestungsnametrim . "" . date("Ymd") . time() . ".png";
	$insert->execute();
	$insert->close();
	$uploaddir = './Ruestungsbilder/';
	$filename = $ruestungsname . date("Ymd") . time();
	$filename = str_replace(" ", "", $filename);
	$fileextension = ".png";
	move_uploaded_file($_FILES["ruestungsbildhochladen"]['tmp_name'], $uploaddir . $filename . $fileextension);
}
// Tränke
if (isset($_POST["trankhochladen"])) {
	$insert = $connection->prepare("INSERT INTO traenke (trankname, trankwert,trankwertpermanent,geldwert,trankbildpfad) VALUES (?,?,?,?,?)");
	$insert->bind_param("siiis", $trankname, $trankwert, $trankwertpermanent, $geldwert, $pfad);
	$trankname = $_POST["trankname"];
	$trankwert = $_POST["trankwert"];
	$trankwertpermanent = $_POST["trankwertpermanent"];
	$geldwert = $_POST["trankgeldwert"];
	$tranknametrim = str_replace(" ", "", $trankname);
	$pfad = "/Traenkebilder/" . $tranknametrim  . "" . date("Ymd") . time() . ".png";
	$insert->execute();
	$insert->close();
	$uploaddir = './Traenkebilder/';
	$filename = $trankname . date("Ymd") . time();
	$filename = str_replace(" ", "", $filename);
	$fileextension = ".png";
	move_uploaded_file($_FILES["trankbildhochladen"]['tmp_name'], $uploaddir . $filename . $fileextension);
}

// Logging Kampf
if (
	isset($_POST["gewinner"]) && isset($_POST["verlierer"]) && isset($_POST["verdienst"])
	&& isset($_POST["verlust"]) && isset($_POST["erfahrung"]) && !isset($_POST["benachrichtigung"])
) {

	$ereignis = "" . $_POST["gewinner"] . " gewinnt gegen " . $_POST["verlierer"] . " +" . $_POST["verdienst"] . " G +" . $_POST["erfahrung"] . " EXP ";
	$newClass->Logging($connection, $ereignis);
}
// Logging Kampf LvL Up
if (isset($_POST["gewinner"]) && isset($_POST["lvl"])) {
	$ereignis = "" . $_POST["gewinner"] . " ist jetzt LvL " . $_POST["lvl"] . "";
	$newClass->Logging($connection, $ereignis);
	$ereignis = "Ist jetzt LvL " . $_POST["lvl"] . "";
	$newClass->NachrichtenAnnehmen($connection, "alle", $ereignis, $_POST["gewinner"]);
}

class DBAktionen
{

	function IstAdmin($connection)
	{
		$admin = $this->SpielerLesen($connection, "Rechte", $_SESSION["Spieler"]);
		if ($admin == "Admin")
			return true;
		else return false;
	}

	// Admin Link einblenden
	function AdminEinblenden($connection)
	{
		$admin = $this->SpielerLesen($connection, "Rechte", $_SESSION["Spieler"]);
		if ($admin == "Admin") {
			echo '<a href="admin.php"><button>Admin</button></a>';
		}
	}
	function LogEinblenden($connection)
	{
		$admin = $this->SpielerLesen($connection, "Rechte", $_SESSION["Spieler"]);
		if ($admin == "Admin") {
			echo '<a href="log.php"><button>Log</button></a>';
		}
	}
	// JSON String des Spielers zurückgeben
	function JSONStringSpieler($connection, $player)
	{
		$return_arr = array();
		$select = $connection->prepare("SELECT * FROM spieler WHERE spielername = ?");
		$select->bind_param("s", $player);
		$select->execute();
		$result = $select->get_result();

		while ($row = $result->fetch_array()) {
			$row_array['spielername'] = $row['spielername'];
			$row_array['lvl'] = $row['lvl'];
			$row_array['erfahrung'] = $row['erfahrung'];
			$row_array['geld'] = $row['geld'];
			$row_array['leben'] = $row['leben'];
			$row_array['maxleben'] = $row['maxleben'];
			$row_array['angriff'] = $row['angriff'];
			$row_array['verteidigung'] = $row['verteidigung'];
			$row_array['waffenwert'] = $this->SpielerWaffenStatsLesen($connection, "waffenwert", $row['waffenid']);
			$row_array['waffenbildpfad'] = $this->SpielerWaffenStatsLesen($connection, "waffenbildpfad", $row['waffenid']);
			$row_array['ruestungswert'] = $this->SpielerRuestungsStatsLesen($connection, "ruestungswert", $row['ruestungsid']);
			$row_array['ruestungsbildpfad'] = $this->SpielerRuestungsStatsLesen($connection, "ruestungsbildpfad", $row['ruestungsid']);
			$row_array['spielerbildpfad'] = $row['spielerbildpfad'];
			$row_array['waffenid'] = $row['waffenid'];
			$row_array['ruestungsid'] = $row['ruestungsid'];
			array_push($return_arr, $row_array);
		}
		echo json_encode($return_arr);
	}

	// JSON String des Gegners zurückgeben
	function JSONStringGegner($connection, $id)
	{
		$return_arr = array();
		$select = $connection->prepare("SELECT * FROM gegner WHERE gegnerid = ?");
		$select->bind_param("i", $id);
		$select->execute();
		$result = $select->get_result();

		while ($row = $result->fetch_array()) {
			$row_array['gegnerid'] = $row['gegnerid'];
			$row_array['gegnername'] = $row['gegnername'];
			$row_array['lvl'] = $row['lvl'];
			$row_array['leben'] = $row['leben'];
			$row_array['angriff'] = $row['angriff'];
			$row_array['geld'] = $row['geld'];
			$row_array['gegnerbildpfad'] = $row['gegnerbildpfad'];
			array_push($return_arr, $row_array);
		}
		echo json_encode($return_arr);
	}

	// Spieler sperren
	function Spielersperren($connection, $sperre, $spielername)
	{
		$update = $connection->prepare("UPDATE spieler SET gesperrt=? WHERE spielername=?");
		$update->bind_param("is", $sperre, $spielername);
		$update->execute();
		$update->close();
	}
	// Gegner sperren
	function Gegnersperren($connection, $sperre, $id)
	{
		$update = $connection->prepare("UPDATE gegner SET gesperrt = ? WHERE gegnerid=?");
		$update->bind_param("ii", $sperre, $id);
		$update->execute();
		$update->close();
	}

	// Zurückgegebene Spieler Kampfstats in die DB schreiben
	function SpielerStatsSchreiben($connection, $lvl, $erfahrung, $geld, $leben, $spielerangriff, $spielerverteidigung, $spielermaxleben, $waffenid, $ruestungsid, $spielername)
	{
		$update = $connection->prepare("UPDATE spieler SET lvl=?,erfahrung=?,geld=?,leben=?,angriff=?,verteidigung=?,maxleben=?,waffenid=?,ruestungsid=? WHERE spielername=?");
		$update->bind_param("iiiiiiiiis", $lvl, $erfahrung, $geld, $leben, $spielerangriff, $spielerverteidigung, $spielermaxleben, $waffenid, $ruestungsid, $spielername);
		$update->execute();
		$update->close();
	}
	// Zurückgegebene Gegner Kampfstats in die DB schreiben
	function GegnerStatsSchreiben($connection, $leben, $geld, $id)
	{
		$update = $connection->prepare("UPDATE gegner SET leben=?,geld=? WHERE gegnerid =?");
		$update->bind_param("iii", $leben, $geld, $id);
		$update->execute();
		$update->close();
	}

	// Gegner löschen
	function Gegnerloeschen($connection, $id)
	{
		$delete = $connection->prepare("DELETE from gegner WHERE gegnerid =?");
		$delete->bind_param("i", $id);
		$delete->execute();
		$delete->close();
	}



	// Spieler---------------------------------------------------------------------------------------------
	function SpielerLesen($connection, $var, $player)
	{
		$select = $connection->prepare("SELECT " . $var . " FROM spieler WHERE spielername = ?");
		$select->bind_param("s", $player);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		return $row["" . $var . ""];
	}
	function SpielerWaffenStatsLesen($connection, $feld, $id)
	{
		$select = $connection->prepare("SELECT " . $feld . " FROM waffen WHERE waffenid = ?");
		$select->bind_param("i", $id);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		return $row["" . $feld . ""];
	}
	function SpielerRuestungsStatsLesen($connection, $feld, $id)
	{
		$select = $connection->prepare("SELECT " . $feld . " FROM ruestung WHERE ruestungsid = ?");
		$select->bind_param("i", $id);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		return $row["" . $feld . ""];
	}
	function MAXErfahrung($connection, $player)
	{
		$select = $connection->prepare("SELECT lvl FROM spieler WHERE spielername = ?");
		$select->bind_param("s", $player);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		echo (($row["lvl"]) * 100);
	}

	function BildLesen($connection, $field, $tabellen, $id, $spielername)
	{
		$select = $connection->prepare("SELECT " . $field . " FROM spieler," . $tabellen . "   
		WHERE spielername = ?
		AND spieler." . $id . " = " . $tabellen . "." . $id . "");
		$select->bind_param("s", $spielername);
		$select->execute();
		$result = $select->get_result();
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$idtemp = $row['' . $field . ''];
			echo $idtemp;
		} else {
			if ($field == "waffenbildpfad")
				echo "/Waffenbilder/Waffe_Default.png";
			if ($field == "ruestungsbildpfad")
				echo "/Ruestungsbilder/Ruestung_Default.png";
			if ($field == "waffenname")
				echo "Keine Waffe angelegt";
			if ($field == "ruestungsname")
				echo "Keine Rüstung angelegt";
		}
	}
	function Bildaendern($connection, $pfad, $player)
	{
		$update = $connection->prepare("UPDATE spieler SET spielerbildpfad= ? WHERE spielername= ?");
		$update->bind_param("ss", $pfad, $player);
		$update->execute();
	}

	//Spielerübersicht  ---------------------------------------------------------------------------------------------
	function AlleSpielerLesen($connection)
	{
		$select = $connection->prepare("SELECT spielerbildpfad, spielername, lvl FROM spieler ORDER BY lvl DESC,spielername ASC");
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			echo ("<img src=" . ($row['spielerbildpfad']) . "> &nbsp
			" . $row['spielername'] . "&nbsp lvl: &nbsp" . $row['lvl'] . "<br>");
		}
	}
	//SpielerKampf PVP ---------------------------------------------------------------------------------------------
	function AlleSpielerKampf($connection)
	{
		if (
			$this->SpielerLesen($connection, "leben", $_SESSION["Spieler"]) > 0
			&& $this->SpielerLesen($connection, "gesperrt", $_SESSION["Spieler"]) === 0
		) {
			$lvl = $this->SpielerLesen($connection, "lvl", $_SESSION["Spieler"]);
			$eigenerSpieler = $_SESSION["Spieler"];
			$sperre = 0;
			$leben = 0;
			$select = $connection->prepare("SELECT spielerbildpfad, spielername, lvl FROM spieler WHERE gesperrt = ? AND lvl >=? AND spielername !=? AND leben >? ORDER BY lvl");
			$select->bind_param("iisi", $sperre, $lvl, $eigenerSpieler, $leben);
			$select->execute();
			$result = $select->get_result();
			while ($row = $result->fetch_array()) {
				echo ("
			    <div class=\"GegenstandEinzeln\">
			    <img src=" . ($row['spielerbildpfad']) . "" . " width=\"100\" height=\"100\">			
				<p>" . $row['spielername'] . "</p><p>Level : " . $row["lvl"] . "</p>
				<form action=\"/pvp.php\" method=\"POST\">
				<input type=\"hidden\" name=\"spielergegner\" value=\"" . $row['spielername'] . "\" />
				<input class=\"Kampfimg\" type=\"image\"src=\"/Bilder/Kampf.png\" width=\"80\" height=\"80\">
				</form>
				</div>");
			} // lol
		} else {
			if ($this->SpielerLesen($connection, "gesperrt", $_SESSION["Spieler"]) === 1) {
				echo '	<div class=GegenstandEinzeln>
				<p>Du bist im Augenblick gesperrt !</p>
				</div>s';
			} else {
				echo '
			<div class=GegenstandEinzeln>
			<p>Du bist verletzt und kannst nicht kämpfen !</p>
			<img src="/Bilder/Leben.png" title="Du bist verletzt">
			</div>';
			}
		}
	}




	//Waffen und Rüstung Kaufen  ---------------------------------------------------------------------------------------------
	function Kaufen($connection, $tabelle, $typid, $id)
	{
		$geld = $this->SpielerLesen($connection, "geld", $_SESSION["Spieler"]);
		$select = $connection->prepare("SELECT * FROM " . $tabelle . " WHERE " . $typid . " =?");
		$select->bind_param("i", $id);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		$kosten = $row["geldwert"];
		if ($tabelle === "waffen") {
			$waffenname = $row["waffenname"];
			$this->Logging($connection, "" . $waffenname . " fuer " . $kosten . " Geld gekauft");
		}
		if ($tabelle === "ruestung") {
			$ruestungsname = $row["ruestungsname"];
			$this->Logging($connection, "" . $ruestungsname . " fuer " . $kosten . " Geld  gekauft");
		}

		if ($geld >= $kosten) {
			$neuesguthaben = $geld - $kosten;
			$update = $connection->prepare("UPDATE spieler SET " . $typid . "=?, geld=? WHERE spielername=?");
			$update->bind_param("iis", $id, $neuesguthaben, $_SESSION["Spieler"]);
			$update->execute();
		}
	}

	//Tränke kaufen
	function TränkeKaufen($connection, $id)
	{
		$geld = $this->SpielerLesen($connection, "geld", $_SESSION["Spieler"]);
		$select = $connection->prepare("SELECT geldwert,trankname,trankwert,trankwertpermanent FROM traenke WHERE trankid =?");
		$select->bind_param("i", $id);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		$kosten = $row["geldwert"];
		$trankwert = $row["trankwert"];
		$trankname = $row["trankname"];
		$trankwertpermanent = $row["trankwertpermanent"];

		$leben = $this->SpielerLesen($connection, "leben", $_SESSION["Spieler"]);
		$maxleben = $this->SpielerLesen($connection, "maxleben", $_SESSION["Spieler"]);

		if ($geld >= $kosten) {
			$leben += $trankwert;
			if ($leben > $maxleben) {
				$leben = $maxleben;
			}
			$neuesguthaben = $geld - $kosten;
			$update = $connection->prepare("UPDATE spieler SET leben=?,maxleben=maxleben+?, geld=? WHERE spielername=?");
			$update->bind_param("iiis", $leben, $trankwertpermanent, $neuesguthaben, $_SESSION["Spieler"]);
			$update->execute();
		}
		//$this->Logging($connection, "" . $trankname . " fuer " . $kosten . " Geld gekauft");
	}
	//WaffenContainer  ---------------------------------------------------------------------------------------------
	function AlleWaffenLesen($connection)
	{
		$geld = $this->SpielerLesen($connection, "geld", $_SESSION["Spieler"]);
		$select = $connection->prepare("SELECT waffenbildpfad, waffenid, waffenname, waffenwert, geldwert FROM waffen WHERE waffenid !=0");
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			if ($geld >= $row['geldwert'])
				echo ("
			<div class=\"GegenstandEinzeln\">
			<img src=" . ($row['waffenbildpfad']) . "" . "> &nbsp
			<p>
			" . $row['waffenname'] . "</p>&nbsp <p>Angriff: &nbsp" . $row['waffenwert'] . "</p>
			 &nbsp <p>Kostet: &nbsp " . $row['geldwert'] . "<img  id=\"geld\" src=\"Bilder/Geld.png\" width=\"30\" height=\"30\"></p>
			 <form action=\"marktplatz.php\" method=\"POST\">
			 <input type=\"hidden\" name=\"waffenid\" value=\"" . $row['waffenid'] . "\" />
			 <input type=\"image\" src=\"/Bilder/Geldsack.png\" >
			 </form>
			 </div><br><br>");
			else {
				echo ("
				<div class=\"GegenstandEinzeln\">
				<img src=" . ($row['waffenbildpfad']) . "" . "> &nbsp
				<p>
				" . $row['waffenname'] . "</p>&nbsp <p>Angriff: &nbsp" . $row['waffenwert'] . "</p>
				 &nbsp <p>Kostet: &nbsp " . $row['geldwert'] . "<img  id=\"geld\" src=\"Bilder/Geld.png\" width=\"30\" height=\"30\"></p>
				 <img id=\"GeldX\" src=\"/Bilder/GeldsackX.png\" title=\"Zu wenig Geld\">
				 </div>");
			}
		}
	}
	//RüstungsContainer  ---------------------------------------------------------------------------------------------
	function AlleRüstungenLesen($connection)
	{
		$geld = $this->SpielerLesen($connection, "geld", $_SESSION["Spieler"]);
		$select = $connection->prepare("SELECT ruestungsbildpfad, ruestungsid, ruestungsname, ruestungswert, geldwert FROM ruestung WHERE ruestungsid !=0");
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			if ($geld >= $row['geldwert']) {
				echo ("
			<div class=\"GegenstandEinzeln\">
			<img src=" . ($row['ruestungsbildpfad']) . "" . "> &nbsp
			<p>
			 " . $row['ruestungsname'] . "</p>&nbsp <p>Verteidigung: &nbsp" . $row['ruestungswert'] . "</p>
			 &nbsp <p>Kostet: &nbsp " . $row['geldwert'] . "<img  id=\"geld\" src=\"Bilder/Geld.png\" width=\"30\" height=\"30\"></p>
			 <form action=\"marktplatz.php\" method=\"POST\">
			 <input type=\"hidden\" name=\"ruestungsid\" value=\"" . $row['ruestungsid'] . "\" />
			 <input type=\"image\" src=\"/Bilder/Geldsack.png\">
			 </form>
			 </div>");
			} else {
				echo ("
				<div class=\"GegenstandEinzeln\">
				<img src=" . ($row['ruestungsbildpfad']) . "" . "> &nbsp
				<p>
				 " . $row['ruestungsname'] . "</p>&nbsp <p>Verteidigung: &nbsp" . $row['ruestungswert'] . "</p>
				 &nbsp <p>Kostet: &nbsp " . $row['geldwert'] . "<img  id=\"geld\" src=\"Bilder/Geld.png\" width=\"30\" height=\"30\"></p>
				 <img id=\"GeldX\" src=\"/Bilder/GeldsackX.png\" title=\"Zu wenig Geld\">
				 </div>");
			}
		}
	}

	//HeilstubenContainer  ---------------------------------------------------------------------------------------------
	function AlleTraenkeLesen($connection)
	{
		$geld = $this->SpielerLesen($connection, "geld", $_SESSION["Spieler"]);
		$select = $connection->prepare("SELECT trankbildpfad, trankid, trankname, trankwert,trankwertpermanent, geldwert FROM traenke ORDER BY geldwert ASC");
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			if ($row['trankwert'] > 0) {
				$typ = "Heilung";
				$value = $row['trankwert'];
			}
			if ($row['trankwertpermanent'] > 0) {
				$typ = "Permanent";
				$value = $row['trankwertpermanent'];
			}

			if ($geld >= $row['geldwert']) {
				echo ("
			<div class=\"GegenstandEinzeln\">
			<img src=" . ($row['trankbildpfad']) . "" . ">&nbsp
			<p>
			" . $row['trankname'] . "</p>
			 <p>" . $typ . " &nbsp" . $value . "</p>
			 <p>Kostet: &nbsp " . $row['geldwert'] . "<img id=\"geld\" src=\"Bilder/Geld.png\"></p>
			 <form action=\"marktplatz.php\" method=\"POST\">
			 <input type=\"hidden\" name=\"trankid\" value=\"" . $row['trankid'] . "\" />
			 <input id=\"audio\" type=\"image\" src=\"/Bilder/Geldsack.png\">
			 </form>
			 </div>");
			} else {
				echo ("
				<div class=\"GegenstandEinzeln\">
				<img src=" . ($row['trankbildpfad']) . "" . ">&nbsp
				<p>
				" . $row['trankname'] . "</p>
				 <p>" . $typ . " &nbsp" . $value . "</p>
				 <p>Kostet: &nbsp " . $row['geldwert'] . "<img id=\"geld\" src=\"Bilder/Geld.png\"></p>
                 <img id=\"GeldX\" src=\"/Bilder/GeldsackX.png\" title=\"Zu wenig Geld\">
				 </div>");
			}
		}
	}

	// admin.php -----------------------------------------------------------------------------------------------
	// Themen auswahl auslesen----------------------------------------------------------------------------------
	function Themenlesen($connection)
	{
		$select = $connection->prepare("SELECT id, themenname from themen");
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			echo '<option value="' . $row["themenname"] . '">' . $row["themenname"] . '</option>';
		}
	}

	// themen.php
	// Themen anzeigen bei denen Gegner zugewiesen sind
	function ThemenAnzeigen($connection)
	{
		$select = $connection->prepare("SELECT DISTINCT themenname, themenbildpfad from themen INNER JOIN gegner ON  gegner.thema = themen.themenname ORDER BY id ASC");
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			echo ('
			<div class=GegenstandEinzeln>
			<img src=' . $row["themenbildpfad"] . ' width=100 height=100>
			<p>' . $row["themenname"] . '</p>
			<p>Anzahl Gegner</p>
			<p>' . $this->ThemenGegnerAnzahl($connection, $row["themenname"]) . '</p>
			<form action="themengegner.php" method="POST">
			<input type=hidden name="themenname" value="' . $row["themenname"] . '" />
			<input type=image src="/Bilder/Schild.png" width=80 height=80 onclick="PlaySound();">
			</form>
		    </div>');
		}
	}
	function ThemenGegnerAnzahl($connection, $themenname)
	{
		$sperre = 0;
		$select = $connection->prepare("SELECT COUNT(gegnername)AS anzahl FROM gegner WHERE thema=? AND gesperrt=?");
		$select->bind_param("si", $themenname, $sperre);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		return $row["anzahl"];
	}
	function ThemenGegnerAnzeigen($connection, $themenname)
	{
		if (
			$this->SpielerLesen($connection, "leben", $_SESSION["Spieler"]) > 0
			&& $this->SpielerLesen($connection, "gesperrt", $_SESSION["Spieler"]) === 0
		) {
			$sperre = 0;
			$select2 = $connection->prepare("SELECT gegnername,gegnerid,gegnerbildpfad, lvl FROM gegner WHERE thema=? AND leben >0 AND gesperrt=? ORDER BY lvl ASC");
			$select2->bind_param("si", $themenname, $sperre);
			$select2->execute();
			$result2 = $select2->get_result();
			while ($row2 = $result2->fetch_array()) {
				echo
					"
				<div class=GegenstandEinzeln>
				<img src=" . $row2["gegnerbildpfad"] . " width=100 height=100>
				<p>" . $row2["gegnername"] . "</p><p>Level : " . $row2["lvl"] . "</p>
				<form action=\"/pve.php\" method=\"POST\">
				   <input type=\"hidden\" name=\"gegnerid\" value=\"" . $row2['gegnerid'] . "\" />
				   <input class=\"Kampfimg\" type=\"image\"src=\"/Bilder/Kampf.png\" width=\"60\" height=\"60\" onclick=\"PlaySound();\">
				   </form></p>
				   </div>";
			}
		} else {

			if ($this->SpielerLesen($connection, "gesperrt", $_SESSION["Spieler"]) === 1) {
				echo '	<div class=GegenstandEinzeln>
				<p>Du bist im Augenblick gesperrt !</p>
				</div>s';
			} else {
				echo '
			<div class=GegenstandEinzeln>
			<p>Du bist verletzt und kannst nicht kämpfen !</p>
			<img src="/Bilder/Leben.png" title="Du bist verletzt">
			</div>';
			}
		}
	}

	// Logging
	function Logging($connection, $ereignis)
	{
		$insert = $connection->prepare("INSERT INTO `log` (ereignis, spieler) VALUES (?,?)");
		$insert->bind_param("ss", $ereignis, $_SESSION["Spieler"]);
		$insert->execute();
		$insert->close();
	}

	//Logübersicht  ---------------------------------------------------------------------------------------------
	function AlleLogsLesen($connection)
	{
		$select = $connection->prepare("SELECT * FROM log ORDER BY datum DESC");
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			echo "<table>
			      <tr>
				  <td>" . $row['id'] . "</td>
				  <td>" . $row['datum'] . "</td>
				  <td>" . $row['ereignis'] . "</td>
				  <td>" . $row['spieler'] . "</td>
				  </tr>
				  </table>";
		}
	}

	// Nachrichten in DB schreiben
	function NachrichtenAnnehmen($connection, $id, $nachrichtentext, $absender)
	{
		if ($id === "alle") {
			$select = $connection->prepare("SELECT id FROM spieler");
			$select->execute();
			$result = $select->get_result();
			while ($row = $result->fetch_array()) {
				$id = $row['id'];
				$insert = $connection->prepare("INSERT INTO `nachrichten` (spielerid,nachrichtentext,absender) VALUES (?,?,?)");
				$insert->bind_param("sss", $nachrichtentext, $absender);
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


	// Nachrichten ----------------------------------------------------------------------------------
	function SpielerSendenAnLesen($connection)
	{
		$select = $connection->prepare("SELECT spielername,id from spieler");
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			echo '<option value="' . $row["id"] . '">' . $row["spielername"] . '</option>';
		}
	}

	// Nachrichten Anzeigen

	function NachrichtenAnzeigen($connection)
	{
		$select = $connection->prepare("SELECT id,erstellt, nachrichtentext,absender FROM nachrichten WHERE spielerid =?");
		$select->bind_param("i", $_SESSION["Spielerid"]);
		$select->execute();
		$result = $select->get_result();
		while ($row = $result->fetch_array()) {
			echo "
			<p>" . $row["erstellt"] . " : " . $row["absender"] . " : " . htmlentities($row["nachrichtentext"], ENT_QUOTES, "UTF-8") . "
			<img id=\"nachrichtloeschen\" src=/Bilder/Mülltonne.png onclick=\"NachrichtLoeschen(" . $row["id"] . ");\">
			";
		}
	}

	//Anzahl der Nachrichten auslesen
	function AnzahlNachrichtenLesen($connection)
	{
		$select = $connection->prepare("SELECT COUNT(spielerid)AS anzahl FROM nachrichten WHERE spielerid=?");
		$select->bind_param("i", $_SESSION["Spielerid"]);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		return $row["anzahl"];
	}

	// Nachricht löschen
	function NachrichtLoeschen($connection, $id)
	{
		$delete = $connection->prepare("DELETE from nachrichten WHERE id =?");
		$delete->bind_param("i", $id);
		$delete->execute();
		$delete->close();
	}

	// Alle Nachricht löschen
	function AlleNachrichtLoeschen($connection)
	{
		$delete = $connection->prepare("DELETE from nachrichten WHERE spielerid =?");
		$delete->bind_param("i", $_SESSION["Spielerid"]);
		$delete->execute();
		$delete->close();
	}


	// Spielername bei ID Übergabe zurückgeben
	function SpielernameIDLesen($connection, $id)
	{
		$select = $connection->prepare("SELECT spielername from spieler WHERE id=?");
		$select->bind_param("i", $id);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		return $row["spielername"];
	}
	function SpielerIDNameLesen($connection, $spielername)
	{
		$select = $connection->prepare("SELECT id from spieler WHERE spielername=?");
		$select->bind_param("s", $spielername);
		$select->execute();
		$result = $select->get_result();
		$row = $result->fetch_assoc();
		return $row["id"];
	}
}
