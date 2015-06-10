<?php
/*Program: addToCharacterTreasureAndXP.php
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

$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
?>

<html>
<head><title>Coins Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Coins Updated.";
	echo "<br/><br/>";
	echo "<a href='awardtreasureandxp.php?CharacterId={$characterId}'>Return to award treasure and xp</a>";
?>
</body>
</html>