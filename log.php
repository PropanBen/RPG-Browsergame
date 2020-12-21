<?php
include("funktionen.php");

$admin = $newClass->IstAdmin($connection);
if ($admin === false)
    header('location: rpg.php');
?>

<html>

<head>
    <title>Log</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="rpgstyle.css" />
    <link rel="stylesheet" type="text/css" href="mobilerpgstyle.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="Hintergrund"></div>

    <div class="Zurückbutton">
        <a href="/rpg.php"><img src="Bilder/Zurückbutton.png" width="100" height="100" /></a>
    </div>

    <div class="Waffencontainer">
        <div class="Logliste"></div>
        <?php $newClass->AlleLogsLesen($connection) ?>
    </div>
</body>

</html>