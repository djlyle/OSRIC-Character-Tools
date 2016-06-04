<?php
/*
File: addToCharacterTreasureAndXP.php
Author: Daniel Lyle
Copyright: June 17,2015
Desc: Add treasure and XP to a character
*/
include(dirname(__FILE__)."/inc/misc.inc");
require_once("./inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];
$coinRows = $_POST['coin'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);

foreach($coinRows as $row)
{
		$coinId = $row['coinId'];
		$quantityToAdd = $row['quantity'];
		//Add coin to character's carried coin inventory
		$myOsricDb->addToCharacterCoins($characterId,$coinId,$quantityToAdd,2);
}

$experiencePointsToAdd = $_POST['experiencePtsToAdd'];
$myOsricDb->addToCharacterXP($characterId,$experiencePointsToAdd);

$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
?>

<html>
<head><title>Coins and XP Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Coins and XP Updated.";
	echo "<br/><br/>";
	echo "<a href='characters.php'>Return to list of characters</a>";
?>
</body>
</html>