<?php
$text = stripslashes ($_REQUEST['text']);

if ($_POST['text'])
{	
				include "remotetypograf.php";
				
				$remoteTypograf = new RemoteTypograf();

				$remoteTypograf->htmlEntities();
				$remoteTypograf->br (false);
				$remoteTypograf->p (true);
				$remoteTypograf->nobr (3);
				$remoteTypograf->quotA ('laquo raquo');
				$remoteTypograf->quotB ('bdquo ldquo');

				print $remoteTypograf->processText ($text);
}
?>