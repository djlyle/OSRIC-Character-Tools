<?php
include_once("./inc/misc.inc");
include_once("./inc/charactertblfuncs.inc");
require_once("./inc/OsricDb.php");

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
	array("CharacterName","CharacterAge","CharacterGender","CharacterWeight","CharacterHeight","RaceId");
	$myOsricDb->createCharacter($_POST['CharacterName'],$_POST['CharacterAge'],$_POST['CharacterGender'],$_POST['CharacterWeight'],$_POST['CharacterHeight'],$_POST['RaceId']);
}
else 
{
	$myOsricDb->editCharacter($_POST);
}

echo "<p>Character updated.</p>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>