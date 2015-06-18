<?php
/*
File: addToCharacterInventory.php
Author: Daniel Lyle
Copyright: June 17, 2015
Desc: Adds items to character's inventory
*/
include(dirname(__FILE__)."/inc/misc.inc");
require_once("./inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];
$itemRows = $_POST['item'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);

foreach($itemRows as $itemRow)
{
		$itemId = $itemRow['itemId'];
		$quantityToAdd = $itemRow['quantity'];
		$myOsricDb->addToCharacterItems($characterId,$itemId,$quantityToAdd);
}

$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
?>

<html>
<head><title>Items Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Inventory Updated.";
	echo "<br/><br/>";
	echo "<a href='equipcharacter.php?CharacterId={$characterId}'>Return to character's equipment list</a>";
?>
</body>
</html>