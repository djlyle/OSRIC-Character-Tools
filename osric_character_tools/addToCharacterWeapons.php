<?php
/*Program: addToCharacterWeapons.php
   Desc: Adds weapons to character's inventory
*/
include_once("./inc/misc.inc");
include_once("./inc/charactertblfuncs.inc");
require_once("./inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];
$weaponRows = $_POST['weapon'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
foreach($weaponRows as $weaponRow)
{
    $weaponId = $weaponRow['weaponId'];
	 $quantityToAdd = $weaponRow['quantity'];
	 $myOsricDb->addToCharacterWeapons($characterId, $weaponId, $quantityToAdd);	 
}
?>

<html>
<head><title>Weapons Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Inventory Updated.";
	echo "<br/><br/>";
	echo "<a href='equipcharacter.php?CharacterId={$characterId}'>Return to character's equipment list</a>";
?>
</body>
</html>