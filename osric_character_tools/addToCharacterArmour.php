<?php
/*Program: addToCharacterArmour.php
   Desc: Adds armour to character's inventory
*/
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
require_once("./inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];
$armourRows = $_POST['armour'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
$num_rows = count($armourRows);
foreach($armourRows as $armourRow)
{
    $armourId = $armourRow['armourId'];
    $quantityToAdd = $armourRow['quantity'];
    $myOsricDb->addToCharacterArmour($characterId, $armourId, $quantityToAdd)
}
?>

<html>
<head><title>Armour Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Inventory Updated.";
	echo "<br/><br/>";
	echo "<a href='equipcharacter.php?CharacterId={$characterId}'>Return to character's equipment list</a>";
?>
</body>
</html>