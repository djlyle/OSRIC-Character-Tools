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
$characterStatusUpdateRows = $_POST['characterstatus'];
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
foreach($characterStatusUpdateRows as $statusUpdateRow)
{
	$myOsricDb->updateCharacterStatus($characterId,$statusUpdateRow['statusId'],$statusUpdateRow['value']);
}
echo "<p>Character status updated.</p>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>