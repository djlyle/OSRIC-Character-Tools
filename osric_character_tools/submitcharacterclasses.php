<?php
/*
File: submitcharacterclasses.php
Author: Daniel Lyle
Copyright: June 17,2015
*/
include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$characterId = $_POST['CharacterId'];
/*If the cancel button was pressed in the form from editcharacterclasses.php
  then return to characters.php */
if(@$_POST['cancelbutton'] == "Cancel")
{
	header("Location: characters.php");
	exit();
}

$selectedCharacterClasses = $_POST['characterClass'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$myOsricDb->editCharacterClasses($characterId,$selectedCharacterClasses);
echo "<p>Character classes updated.</p>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>