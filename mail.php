
<?php

$recipient = 'propanben@freenet.de';
$subject = 'some test mail';
$content = 'this is some send mail to check if the mail is delivered correctly';
$sender = 'info@propanben.de';
mail($recipient, $subject, $content, $sender, ' -f ' . $sender);
?>
