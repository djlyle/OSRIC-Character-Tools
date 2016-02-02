<?php
/*
File: characterinventory.php
Author: Daniel Lyle
Copyright: June 1,2015
*/
include_once(dirname(__FILE__)."/inc/misc.inc");
//include_once(dirname(__FILE__)."/inc/characterInventory.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");
require_once(dirname(__FILE__)."/inc/OsricHtmlHelper.php");

$characterId = $_REQUEST['CharacterId'];
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
$totalEncumbranceOnPerson = $myOsricDb->getTotalEncumbranceOnPerson($characterId);
?>

<html>
<header><title><?php echo "{$characterName}'s Equipment List"; ?></title></header>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
<body>
<form action="editCharacterInventory.php" method="POST">

<?php
echo "<h3>{$characterName}</h3>\n";
echo "Total Encumbrance: \n";
echo "{$totalEncumbranceOnPerson} (lbs)";
echo "<br/>\n";
echo "<br/>\n";
echo "<a href='characters.php'>Return to list of characters</a>\n";
echo "<p>View and/or modify the character inventory below.</p>";
echo "<p>Press the submit button below when ready to finalize any changes.</p>";
echo "<div><input type='submit' value='submit inventory changes'/></div>\n";
echo "<hr/>\n";
echo "<div id='CharacterInventoryContent' class='clsScrollable'>\n";
$itemStatusOptions = $myOsricDb->getItemStatusOptions();

//Html form will POST row data via an array.  Each row will be POSTED with a given index.
//If same array name is used in multiple tables then the starting index for that array will
//differ. The variable postArrayIndexOffset is the index to start with for the array used in POSTing the input elements 
//in the rows of the html table in question.
$postArrayIndexOffset = 0;

$character_coins_in_use = $myOsricDb->getCharacterCoinsInUse($characterId);
$num_rows = count($character_coins_in_use);
if($num_rows > 0){
	echo "<h3>Coins in use:</h3>\n";
	OsricHtmlHelper::makeHtmlTableCharacterCoins($character_coins_in_use, $itemStatusOptions, "osric_character_coins_in_use",$postArrayIndexOffset);
	$postArrayIndexOffset = $postArrayIndexOffset + $num_rows;
}

echo "<h3>Coins carried:</h3>\n";
$character_coins_carried = $myOsricDb->getCharacterCoinsCarried($characterId);
$num_rows = count($character_coins_carried);
OsricHtmlHelper::makeHtmlTableCharacterCoins($character_coins_carried, $itemStatusOptions, "osric_character_coins_carried", $postArrayIndexOffset);
$postArrayIndexOffset = $postArrayIndexOffset + $num_rows;

echo "<h3>Coins in storage:</h3>\n";
$character_coins_in_storage = $myOsricDb->getCharacterCoinsInStorage($characterId);
OsricHtmlHelper::makeHtmlTableCharacterCoins($character_coins_in_storage, $itemStatusOptions, "osric_character_coins_in_storage", $postArrayIndexOffset);

echo "<hr/>\n";

echo "<h3>Armour:</h3>\n";
echo "<p>To transfer a quantity of armour in a row from one employment to another (e.g. from in storage to being carried), modify the Transfer Destination field of the row in question and enter a non-zero Transfer Quantity. Then click the \"submit armour\" button to submit the transfer and commit it to the database.</p>\n";
echo "<br/>\n";

$itemOffset = 0;
echo "<h3>Armour in Use:</h3>";
$character_armour_in_use = $myOsricDb->getCharacterArmourInUse($characterId);
$num_rows = count($character_armour_in_use);
OsricHtmlHelper::makeHtmlTableCharacterArmour($character_armour_in_use, $itemStatusOptions, "osric_character_armour_in_use", $itemOffset);
$itemOffset = $itemOffset + $num_rows;
echo "<h3>Armour Carried:</h3>";
$character_armour_carried = $myOsricDb->getCharacterArmourCarried($characterId);
$num_rows = count($character_armour_carried);
OsricHtmlHelper::makeHtmlTableCharacterArmour($character_armour_carried, $itemStatusOptions, "osric_character_armour_carried", $itemOffset);
$itemOffset = $itemOffset + $num_rows;
echo "<h3>Armour In Storage: </h3>";
$character_armour_in_storage = $myOsricDb->getCharacterArmourInStorage($characterId);
$num_rows = count($character_armour_in_storage);
OsricHtmlHelper::makeHtmlTableCharacterArmour($character_armour_in_storage, $itemStatusOptions, "osric_character_armour_in_storage", $itemOffset);
$itemOffset = $itemOffset + $num_rows;
echo "<hr/>\n";

echo "<h3>Weapons:</h3>";
echo "<p>To transfer a quantity of weapons in a row from one employment to another (e.g. from in storage to being carried), modify the Transfer Destination field of the row in question and enter a non-zero Transfer Quantity. Then click the \"submit weapons\" button to submit the transfer and commit it to the database.</p>\n";
echo "<br/>";

echo "<h3>Weapons in Use:</h3>";
$character_weapons_in_use = $myOsricDb->getCharacterWeaponsInUse($characterId);
$num_rows = count($character_weapons_in_use);
OsricHtmlHelper::makeHtmlTableCharacterWeapons($character_weapons_in_use, $itemStatusOptions, "osric_character_weapons_in_use", $itemOffset);
$itemOffset = $itemOffset + $num_rows;
echo "<h3>Weapons Carried:</h3>\n";
$character_weapons_carried = $myOsricDb->getCharacterWeaponsCarried($characterId);
$num_rows = count($character_weapons_carried);
OsricHtmlHelper::makeHtmlTableCharacterWeapons($character_weapons_carried, $itemStatusOptions, "osric_character_weapons_carried", $itemOffset);
$itemOffset = $itemOffset + $num_rows;
echo "<h3>Weapons in Storage:</h3>\n";
$character_weapons_in_storage = $myOsricDb->getCharacterWeaponsInStorage($characterId);
$num_rows = count($character_weapons_in_storage);
OsricHtmlHelper::makeHtmlTableCharacterWeapons($character_weapons_in_storage, $itemStatusOptions, "osric_character_weapons_in_storage", $itemOffset);
$itemOffset = $itemOffset + $num_rows;
echo "<hr/>\n";

echo "<h3>Equipment:</h3>";
echo "<p>To transfer a quantity of equipment items in a row from one employment to another (e.g. from in storage to being carried), modify the Transfer Destination field of the row in question and enter a non-zero Transfer Quantity. Then click the \"submit equipment\" button to submit the transfer and commit it to the database.</p>\n";
echo "<br/>";

$character_items_in_use = $myOsricDb->getCharacterItemsInUse($characterId);
$num_rows = count($character_items_in_use);
if($num_rows > 0){
	echo "<h3>Equipment In Use:</h3>\n";
	OsricHtmlHelper::makeHtmlTableCharacterEquipment($character_items_in_use, $itemStatusOptions, "osric_character_items_in_use", $itemOffset);
	$itemOffset = $itemOffset + $num_rows;
}

echo "<h3>Equipment Carried:</h3>\n";
$character_items_carried = $myOsricDb->getCharacterItemsCarried($characterId);
$num_rows = count($character_items_carried);
OsricHtmlHelper::makeHtmlTableCharacterEquipment($character_items_carried, $itemStatusOptions, "osric_character_equipment_carried",$itemOffset);
$itemOffset = $itemOffset + $num_rows;

echo "<h3>Equipment in Storage:</h3>\n";
$character_items_in_storage = $myOsricDb->getCharacterItemsInStorage($characterId);
$num_rows = count($character_items_in_storage);
OsricHtmlHelper::makeHtmlTableCharacterEquipment($character_items_in_storage, $itemStatusOptions, "osric_character_equipment_in_storage", $itemOffset);
echo "<hr/>\n";

echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";

//end tag for scrollable div
echo "</div>\n";

?>

</form>
</body>
</html>