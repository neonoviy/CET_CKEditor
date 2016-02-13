<?php

$text = stripslashes ($_REQUEST['text']);

if ($_POST['text'])
{
	require_once("EMT.php");
	$typograf = new EMTypograph();
	$typograf->set_text($text);
	$typograf->setup(array(
		'Text.paragraphs' => 'off',
		'Text.breakline' => 'off',
	));
	$result = $typograf->apply();
	echo $result;
}

?>