<?php
/*
File: submitcharacterstatus.php
Author: Daniel Lyle
Copyright: June 17,2015
*/
include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");
/*If the cancel button was pressed in the form from editcharacterstatus.php
  then return to characters.php */
if(@$_POST['cancelbutton'] == "Cancel")
{
	header("Location: characters.php");
   exit();
}
$characterId = $_POST['CharacterId'];
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$myOsricDb->editCharacterStatus($characterId,$_POST['CharacterStatusArmourClass'],$_POST['CharacterStatusExperiencePoints'],$_POST['CharacterStatusFullHitPoints'],$_POST['CharacterStatusRemainingHitPoints']);

echo "<p>Character status updated.</p>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>