<?php
include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$characterId = $_POST['CharacterId'];
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);

/*If the cancel button was pressed in the form from editcharacter.php
  then return to characters.php */
if(@$_POST['cancelbutton'] == "Cancel")
{
	header("Location: characters.php");
    exit();
}

/*Note: function editCharacter handles both new and existing characters.  That is, if the character is brand new it inserts it as a new row
  in the database, otherwise it updates an existing row for an existing character in the database*/
if($characterId == -1)
{
	$myOsricDb->createCharacter($_POST['CharacterName'],$_POST['CharacterAge'],$_POST['CharacterGender'],$_POST['CharacterWeight'],$_POST['CharacterHeight'],$_POST['RaceId']);
}
else 
{
	$myOsricDb->editCharacter($characterId,$_POST['CharacterName'],$_POST['CharacterAge'],$_POST['CharacterGender'],$_POST['CharacterWeight'],$_POST['CharacterHeight'],$_POST['RaceId']);
}

echo "<p>Character updated.</p>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>