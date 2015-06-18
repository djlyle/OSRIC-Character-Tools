<?php
/*

File: addToCharacterWeapons.php
Author: Daniel Lyle
Copyright: June 17,2015
Desc: Adds weapons to character's inventory
*/
include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];
$weaponRows = $_POST['weapon'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);

foreach($weaponRows as $weaponRow)
{
    $weaponId = $weaponRow['weaponId'];
	 $quantityToAdd = $weaponRow['quantity'];
	 $myOsricDb->addToCharacterWeapons($characterId, $weaponId, $quantityToAdd);	 
}

$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
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