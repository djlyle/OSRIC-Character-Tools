<?php
include_once("./inc/misc.inc");
include_once("./inc/charactertblfuncs.inc");
require_once("./inc/OsricDb.php");

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