<?php
include("funktionen.php");
$admin = $newClass->IstAdmin($connection);
if ($admin === false)
	header('location: rpg.php');
?>

<html>

<head>
	<title>Admin</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="rpgstyle.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<div class="Hintergrund"></div>

	<div class="Zurückbutton">
		<a href="/rpg.php"><img src="Bilder/Zurückbutton.png" width="100" height="100" /></a>
	</div>


	<div class="Themen">
		<p>Themen hinzufügen</p>
		<form action="/admin.php" method="POST" enctype="multipart/form-data">
			<span>Thema</span><br>
			<input id="thema" type="text" name="thema"><br><br>
			<span>Themabild hochladen</span><br>
			<div class="BildContainer">
				<img class="Bildrahmen" src="/Bilder/Rahmen.png" />
				<img id="Bildvorschauthema" class="Bild" src="/Bilder/Default.png"><br><br>
				<input id="inputfilethema" type="file" name="themabildhochladen" onchange="PreviewImageThema();">
				<input id="loeschenthema" type="button" name="bildloeschen" value="Bild entfernen"><br><br>
			</div>
			<input id="themaspeichern" type="submit" disabled name="themaspeichern" value="speichern"><br>
			<p id="messageboxthema">Bitte alle Felder ausfüllen !</p>
		</form>
	</div>


	<div class="Gegner">
		<p>Gegner hinzufügen</p>
		<form action="/admin.php" method="POST" enctype="multipart/form-data">
			<span>Gegnername</span><br>
			<input id="gegnername" type="text" name="gegnername"><br><br>
			<span>Level</span><br>
			<input id="lvl" type="text" name="lvl"><br><br>
			<span>Lebenspunkte</span><br>
			<input id="lebenspunkte" type="text" name="leben"><br><br>
			<span>Angriffschaden</span><br>
			<input id="angriff" type="text" name="angriff"><br><br>
			<span>Geld</span><br>
			<input id="geld" type="text" name="geld"><br><br>
			<span>Thema</span><br>
			<select id="thema" name="thema">
				<?php $newClass->ThemenLesen($connection); ?>
			</select><br><br>
			<span>Gegnerbild hochladen</span><br>
			<div class="BildContainer">
				<img class="Bildrahmen" src="/Bilder/Rahmen.png" />
				<img id="Bildvorschau" class="Bild" src="/Gegneravatare/Default.png"><br><br>
			</div>
			<input id="inputfile" type="file" name="gegnerbildhochladen" onchange="PreviewImage();">
			<input id="loeschen" type="button" name="bildloeschen" value="Bild entfernen"><br><br>
			<input id="speichern" type="submit" disabled name="gegnerhochladen" value="Speichern">
			<p id="messagebox">Bitte alle Felder ausfüllen !</p>
		</form>
	</div>

	<div class="Waffen">
		<p>Waffen hinzufügen</p>
		<form action="/admin.php" method="POST" enctype="multipart/form-data">
			<span>Waffenname</span><br>
			<input id="waffenname" type="text" name="waffenname"><br><br>
			<span>Waffenwert</span><br>
			<input id="waffenwert" type="text" name="waffenwert"><br><br>
			<span>Kosten</span><br>
			<input id="waffengeld" type="text" name="waffengeldwert"><br><br>
			<span>Waffenbildbild hochladen</span><br>
			<div class="BildContainer">
				<img class="Bildrahmen" src="/Bilder/Rahmen.png" />
				<img id="BildvorschauWaffen" class="Bild" src="/Waffenbilder/Waffe_Default.png"><br><br>
			</div>
			<input id="inputfilewaffen" type="file" name="waffenbildhochladen" onchange="PreviewImageWaffen();">
			<input id="waffenloeschen" type="button" name="bildloeschenwaffen" value="Bild entfernen"><br><br>
			<input id="waffenspeichern" type="submit" disabled name="waffenhochladen" value="Speichern">
			<p id="waffenmessagebox">Bitte alle Felder ausfüllen !</p>
		</form>
	</div>

	<div class="Ruestung">
		<p>Rüstung hinzufügen</p>
		<form action="/admin.php" method="POST" enctype="multipart/form-data">
			<span>Rüstungsname</span><br>
			<input id="ruestungsname" type="text" name="ruestungsname"><br><br>
			<span>Rüstungswert</span><br>
			<input id="ruestungswert" type="text" name="ruestungswert"><br><br>
			<span>Kosten</span><br>
			<input id="ruestungsgeld" type="text" name="ruestungsgeldwert"><br><br>
			<span>Rüstungsbildbild hochladen</span><br>
			<div class="BildContainer">
				<img class="Bildrahmen" src="/Bilder/Rahmen.png" />
				<img id="BildvorschauRuestung" class="Bild" src="/Ruestungsbilder/Ruestung_Default.png"><br><br>
			</div>
			<input id="inputfileruestung" type="file" name="ruestungsbildhochladen" onchange="PreviewImageRuestung();">
			<input id="ruestungloeschen" type="button" name="bildloeschenruestung" value="Bild entfernen"><br><br>
			<input id="ruestungsspeichern" type="submit" disabled name="ruestunghochladen" value="Speichern">
			<p id="ruestungsmessagebox">Bitte alle Felder ausfüllen !</p>
		</form>
	</div>

	<div class="Tränke">
		<p>Trank hinzufügen</p>
		<form action="/admin.php" method="POST" enctype="multipart/form-data">
			<span>Trankname</span><br>
			<input id="trankname" type="text" name="trankname"><br><br>
			<span>Trankwert</span><br>
			<input id="trankwert" type="text" name="trankwert"><br><br>
			<span>Trankwert Permanent</span><br>
			<input id="trankwertpermanent" type="text" name="trankwertpermanent"><br><br>
			<span>Trankwert Verteidigung</span><br>
			<input id="trankwertverteidigung" type="text" name="trankwertverteidigung"><br><br>
			<span>Trankwert Angriff</span><br>
			<input id="trankwertangriff" type="text" name="trankwertangriff"><br><br>
			<span>Kosten</span><br>
			<input id="trankgeld" type="text" name="trankgeldwert"><br><br>
			<span>Trankbildbild hochladen</span><br>
			<div class="BildContainer">
				<img class="Bildrahmen" src="/Bilder/Rahmen.png" />
				<img id="BildvorschauTrank" class="Bild" src="/Traenkebilder/Trank_Default.png"><br><br>
			</div>
			<input id="inputfiletrank" type="file" name="trankbildhochladen" onchange="PreviewImageTrank();">
			<input id="trankloeschen" type="button" name="bildloeschentrank" value="Bild entfernen"><br><br>
			<input id="trankspeichern" type="submit" disabled name="trankhochladen" value="Speichern">
			<p id="trankmessagebox">Bitte alle Felder ausfüllen !</p>
		</form>
	</div>

	<script type="text/javascript" src="admin.js"></script>
</body>

</html>