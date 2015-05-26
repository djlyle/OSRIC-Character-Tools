<?php
include_once("./inc/misc.inc");
include_once("./inc/characterInventory.inc");
include_once("./inc/charactertblfuncs.inc");
include_once("./inc/db_funcs.inc");
include_once("./inc/functions.inc");
require_once("./inc/OsricDb.php");
require_once("./inc/OsricHtmlHelper.php");

$characterId = $_REQUEST['CharacterId'];
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
$totalEncumbranceOnPerson = $myOsricDb->getTotalEncumbranceOnPerson($characterId);
$equipmentStatusOptions = $myOsricDb->getEquipmentStatusOptions();
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
$myOsricHtmlHelper = new OsricHtmlHelper();
echo "<h3>Coins carried:</h3>\n";
$character_coins_carried = $myOsricDb->getCharacterCoinsCarried($characterId);
$num_rows = count($character_coins_carried);
$myOsricHtmlHelper->makeHtmlTableCharacterCoins($character_coins_carried, $itemStatusOptions, "osric_character_coins_carried", $postArrayIndexOffset);
$postArrayIndexOffset = $postArrayIndexOffset + $num_rows;

echo "<h3>Coins in storage:</h3>\n";
$character_coins_in_storage = $myOsricDb->getCharacterCoinsInStorage($characterId);
$num_rows = count($character_coins_in_storage);
$myOsricHtmlHelper->makeHtmlTableCharacterCoins($character_coins_in_storage, $itemStatusOptions, "osric_character_coins_in_storage", $postArrayIndexOffset);
$postArrayIndexOffset = $postArrayIndexOffset + $num_rows;

echo "<hr/>\n";

echo "<h3>Armour:</h3>\n";
echo "<p>Click on the \"Select new armour\" link to supplement this character's existing in storage inventory.  The quantities selected from that list will be added to the character's in storage inventory.</p>\n";
echo "<p>To transfer a quantity of armour in a row from one employment to another (e.g. from in storage to being carried), modify the Transfer Destination field of the row in question and enter a non-zero Transfer Quantity. Then click the \"submit armour\" button to submit the transfer and commit it to the database.</p>\n";
echo "<div><a href='selectarmour.php?CharacterId={$characterId}'>Select new armour</a></div>";
echo "<br/>\n";

$offset = 0;
echo "<h3>Armour in Use:</h3>";
echo "<table id='osric_character_armour_in_use'>\n";
echo "<tr><td>Armour Type</td><td>Effect on Armour Class</td><td>Encumbrance</td><td>Movement Rate</td><td>Cost</td><td>Quantity</td><td>Magic</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>\n";
$character_armour_in_use = $myOsricDb->getCharacterArmourInUse($characterId);
$num_rows = count($character_armour_in_use);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_armour_in_use[$i];
    echo "<tr>";
	echo "<td>{$row['ArmourType']}</td>";
	echo "<td>{$row['ArmourEffectOnArmourClass']}</td>";
    echo "<td>{$row['ArmourEncumbrance']}</td>";
    echo "<td>{$row['ArmourMovementRate']}</td>";
	echo "<td>{$row['ArmourCost']}</td>";
    $characterArmourId = $row['CharacterArmourId'];
    $armourId = $row['ArmourId'];    
    	
    if($row['Quantity']){
		$armourQuantity = $row['Quantity'];
	}
	else {
		$armourQuantity = 0;
	}
    $armourMagic = $row['ArmourMagic'];
    $transferSource = $row['EquipmentStatusId'];
    $index = $offset + $i;
	echo "<td><input type='number' min='0' max='9999999' name='armour[{$index}][quantity]' value='{$armourQuantity}' readonly='readonly'></input></td>";
    echo "<td><input type='number' min='0' max='9999999' name='armour[{$index}][armourMagic]' value='{$armourMagic}' readonly='readonly'></input></td>";	
    echo "<td>";
    html_listbox("armour[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);
    echo "</td>";    
    echo "<td><input type='number' min='0' max='{$armourQuantity}' name='armour[{$index}][transferQuantity]' value='0'></input></td>";
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][armourId]' value='{$armourId}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][characterArmourId]' value='{$characterArmourId}'></input></td>";    
    echo "</tr>\n";
}
echo "</table>\n";

$offset = $offset + $num_rows;

echo "<h3>Armour Carried:</h3>";
echo "<table id='osric_character_armour_carried'>\n";
echo "<tr><td>Armour Type</td><td>Effect on Armour Class</td><td>Encumbrance</td><td>Movement Rate</td><td>Cost</td><td>Quantity</td><td>Magic</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>\n";
$character_armour_carried = $myOsricDb->getCharacterArmourCarried($characterId);
$num_rows = count($character_armour_carried);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_armour_carried[$i];
    echo "<tr>";
	echo "<td>{$row['ArmourType']}</td>";
	echo "<td>{$row['ArmourEffectOnArmourClass']}</td>";
    echo "<td>{$row['ArmourEncumbrance']}</td>";
    echo "<td>{$row['ArmourMovementRate']}</td>";
	echo "<td>{$row['ArmourCost']}</td>";
    $characterArmourId = $row['CharacterArmourId'];
    $armourId = $row['ArmourId'];    
    	
    if($row['Quantity']){
		$armourQuantity = $row['Quantity'];
	}
	else {
		$armourQuantity = 0;
	}
    $armourMagic = $row['ArmourMagic'];
    $transferSource = $row['EquipmentStatusId'];
    $index = $offset + $i;
	echo "<td><input type='number' min='0' max='9999999' name='armour[{$index}][quantity]' value='{$armourQuantity}' readonly='readonly'></input></td>";
    echo "<td><input type='number' min='0' max='9999999' name='armour[{$index}][armourMagic]' value='{$armourMagic}' readonly='readonly'></input></td>";	
    echo "<td>";
    html_listbox("armour[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);    
    echo "</td>";
    echo "<td><input type='number' min='0' max='{$armourQuantity}' name='armour[{$index}][transferQuantity]' value='0'></input></td>";
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][armourId]' value='{$armourId}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][characterArmourId]' value='{$characterArmourId}'></input></td>";    
    echo "</tr>\n";
}
echo "</table>\n";
$offset = $offset + $num_rows;
echo "<h3>Armour In Storage: </h3>";
$character_armour_in_storage = $myOsricDb->getCharacterArmourInStorage($characterId);
$num_rows = count($character_armour_in_storage);
echo "<table id='osric_character_armour_in_storage'>";
echo "<tr><td>Armour Type</td><td>Effect on Armour Class</td><td>Encumbrance</td><td>Movement Rate</td><td>Cost</td><td>Quantity</td><td>Magic</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>\n";
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_armour_in_storage[$i];
    echo "<tr>";
	echo "<td>{$row['ArmourType']}</td>";
	echo "<td>{$row['ArmourEffectOnArmourClass']}</td>";
    echo "<td>{$row['ArmourEncumbrance']}</td>";
    echo "<td>{$row['ArmourMovementRate']}</td>";
	echo "<td>{$row['ArmourCost']}</td>";
    $characterArmourId = $row['CharacterArmourId'];
    $armourId = $row['ArmourId'];    
    	
    if($row['Quantity']){
		$armourQuantity = $row['Quantity'];
	}
	else {
		$armourQuantity = 0;
	}
    $armourMagic = $row['ArmourMagic'];
    $transferSource = $row['EquipmentStatusId'];
    $index = $offset + $i;
	echo "<td><input type='number' min='0' max='9999999' name='armour[{$index}][quantity]' value='{$armourQuantity}' readonly='readonly'></input></td>";
    echo "<td><input type='number' min='0' max='9999999' name='armour[{$index}][armourMagic]' value='{$armourMagic}' readonly='readonly'></input></td>";	
    echo "<td>";
    html_listbox("armour[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);        
    echo "</td>";    
    echo "<td><input type='number' min='0' max='{$armourQuantity}' name='armour[{$index}][transferQuantity]' value='0'></input></td>";
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][armourId]' value='{$armourId}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$index}][characterArmourId]' value='{$characterArmourId}'></input></td>";    
    echo "</tr>\n";
}
echo "</table>\n";
echo "<hr/>\n";

echo "<h3>Weapons:</h3>";
echo "<p>Click on the \"Select new weapons\" link to supplement this character's existing in storage inventory.  The quantities selected from that list will be added to the character's in storage inventory.</p>\n";
echo "<p>To transfer a quantity of weapons in a row from one employment to another (e.g. from in storage to being carried), modify the Transfer Destination field of the row in question and enter a non-zero Transfer Quantity. Then click the \"submit weapons\" button to submit the transfer and commit it to the database.</p>\n";
echo "<div><a href='selectweapons.php?CharacterId={$characterId}'>Select new weapons</a></div>";
echo "<br/>";

echo "<h3>Weapons in Use:</h3>";
echo "<table id='osric_character_weapons_in_use'>\n";
echo "<tr><td>Weapon Type</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Magic</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>";
$character_weapons_in_use = $myOsricDb->getCharacterWeaponsInUse($characterId);
$num_rows = count($character_weapons_in_use);
$offset = 0;
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_weapons_in_use[$i];
    echo "<tr>";
	echo "<td>{$row['WeaponType']}</td>";
	echo "<td>{$row['WeaponEncumbranceInLbs']}</td>";
    echo "<td>{$row['WeaponCost']}</td>";
    $characterWeaponId = $row['CharacterWeaponId'];
	$weaponId = $row['WeaponId'];
	
    if($row['Quantity']){
		$weaponQuantity = $row['Quantity'];
	}
	else {
		$weaponQuantity = 0;
	}
    $weaponMagic = $row['WeaponMagic'];
    $transferSource = $row['EquipmentStatusId'];
    $index = $offset + $i;
		
    echo "<td><input type='number' min='0' max='9999999' name='weapon[{$index}][quantity]' value='{$weaponQuantity}' readonly='readonly'></input></td>";
    echo "<td><input type='number' min='0' max='9999999' name='weapon[{$index}][weaponMagic]' value='{$weaponMagic}' readonly='readonly'></input></td>";	
    echo "<td>";
    html_listbox("weapon[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);        
    echo "</td>";      
    echo "<td><input type='number' min='0' max='{$weaponQuantity}' name='weapon[{$index}][transferQuantity]' value='0'></input></td>";
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][weaponId]' value='{$weaponId}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][characterWeaponId]' value='{$characterWeaponId}'></input></td>";    
    echo "</tr>\n";
}
echo "</table>\n";
$offset = $offset + $num_rows;
echo "<h3>Weapons Carried:</h3>\n";
echo "<table id='osric_character_weapons_carried'>\n";
echo "<tr><td>Weapon Type</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Magic</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>";
$character_weapons_carried = $myOsricDb->getCharacterWeaponsCarried($characterId);
$num_rows = count($character_weapons_carried);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_weapons_carried[$i];
    echo "<tr>";
	echo "<td>{$row['WeaponType']}</td>";
	echo "<td>{$row['WeaponEncumbranceInLbs']}</td>";
    echo "<td>{$row['WeaponCost']}</td>";
    $characterWeaponId = $row['CharacterWeaponId'];
    $weaponId = $row['WeaponId'];
	if($row['Quantity']){
		$weaponQuantity = $row['Quantity'];
	}
	else {
		$weaponQuantity = 0;
	}
    $weaponMagic = $row['WeaponMagic'];
    $transferSource = $row['EquipmentStatusId'];
    $index = $offset + $i;
		
    echo "<td><input type='number' min='0' max='9999999' name='weapon[{$index}][quantity]' value='{$weaponQuantity}' readonly='readonly'></input></td>";
    echo "<td><input type='number' min='0' max='9999999' name='weapon[{$index}][weaponMagic]' value='{$weaponMagic}' readonly='readonly'></input></td>";	
    echo "<td>";
    html_listbox("weapon[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);        
    echo "</td>";      
    echo "<td><input type='number' min='0' max='{$weaponQuantity}' name='weapon[{$index}][transferQuantity]' value='0'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][transferSource]' value='{$transferSource}'></input></td>";
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][weaponId]' value='{$weaponId}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][characterWeaponId]' value='{$characterWeaponId}'></input></td>";    
    echo "</tr>\n";
}
echo "</table>\n";
$offset = $offset + $num_rows;
echo "<h3>Weapons in Storage:</h3>\n";
echo "<table id='osric_character_weapons_in_storage'>\n";
echo "<tr><td>Weapon Type</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Magic</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>";
$character_weapons_in_storage = $myOsricDb->getCharacterWeaponsInStorage($characterId);
$num_rows = count($character_weapons_in_storage);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_weapons_in_storage[$i];
    echo "<tr>";
	echo "<td>{$row['WeaponType']}</td>";
	echo "<td>{$row['WeaponEncumbranceInLbs']}</td>";
    echo "<td>{$row['WeaponCost']}</td>";
    $characterWeaponId = $row['CharacterWeaponId'];
    $weaponId = $row['WeaponId'];
	if($row['Quantity']){
		$weaponQuantity = $row['Quantity'];
	}
	else {
		$weaponQuantity = 0;
	}
    $weaponMagic = $row['WeaponMagic'];
    $transferSource = $row['EquipmentStatusId'];
    $index = $offset + $i;
		
    echo "<td><input type='number' min='0' max='9999999' name='weapon[{$index}][quantity]' value='{$weaponQuantity}' readonly='readonly'></input></td>";
    echo "<td><input type='number' min='0' max='9999999' name='weapon[{$index}][weaponMagic]' value='{$weaponMagic}' readonly='readonly'></input></td>";	
    echo "<td>";
    html_listbox("weapon[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);        
    echo "</td>";
    echo "<td><input type='number' min='0' max='{$weaponQuantity}' name='weapon[{$index}][transferQuantity]' value='0'></input></td>";
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][weaponId]' value='{$weaponId}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$index}][characterWeaponId]' value='{$characterWeaponId}'></input></td>";    
    echo "</tr>\n";
}
echo "</table>\n";
echo "<hr/>\n";

echo "<h3>Equipment:</h3>";
echo "<p>Click on the \"Select new equipment\" link to supplement this character's existing in storage inventory.  The quantities selected from that list will be added to the character's in storage inventory.</p>\n";
echo "<p>To transfer a quantity of equipment items in a row from one employment to another (e.g. from in storage to being carried), modify the Transfer Destination field of the row in question and enter a non-zero Transfer Quantity. Then click the \"submit equipment\" button to submit the transfer and commit it to the database.</p>\n";
echo "<div><a href='selectequipment.php?CharacterId={$characterId}'>Select new equipment</a></div>";
echo "<br/>";
$offset = 0;
echo "<h3>Equipment Carried:</h3>\n";
echo "<table id='osric_character_equipment_carried'>";
echo "<tr><td>Item Name</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>";
$itemQuantity = 0;
$character_items_carried = $myOsricDb->getCharacterItemsCarried($characterId);
$num_rows = count($character_items_carried);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_items_carried[$i];
	echo "<tr>";
	echo "<td>{$row['ItemName']}</td>";
	echo "<td>{$row['ItemEncumbrance']}</td>";
	echo "<td>{$row['ItemCost']}</td>";
    $transferSource = $row['ItemStatusId'];
    $characterItemId = $row['CharacterItemId'];
	$itemId = $row['ItemId'];
    $index = $offset + $i;
		
    if($row['Quantity']){
		$itemQuantity = $row['Quantity'];
	}
	else {
		$itemQuantity = 0;
	}
	echo "<td><input type='number' min='0' max='9999999' name='item[{$index}][quantity]' value='{$itemQuantity}'></input></td>";
    echo "<td>";
    html_listbox("item[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);        
    echo "</td>";
    echo "<td><input type='number' min='0' max='{$itemQuantity}' name='item[{$index}][transferQuantity]' value='0'></input></td>";
    
    echo "<td><input type='hidden' min='0' max='9999999' name='item[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='item[{$index}][itemId]' value='{$itemId}'></input></td>";
    echo "<td><input type='hidden' min='0' max='9999999' name='item[{$index}][characterItemId]' value='{$characterItemId}'></input></td>";     
    echo "</tr>\n";
}
echo "</table>\n";

$offset = $offset + $num_rows;

echo "<h3>Equipment in Storage:</h3>\n";
echo "<table id='osric_character_equipment_in_storage'>";
echo "<tr><td>Item Name</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>";
$character_items_in_storage = $myOsricDb->getCharacterItemsInStorage($characterId);
$num_rows = count($character_items_in_storage);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_items_in_storage[$i];
	echo "<tr>";
	echo "<td>{$row['ItemName']}</td>";
	echo "<td>{$row['ItemEncumbrance']}</td>";
	echo "<td>{$row['ItemCost']}</td>";
    $transferSource = $row['ItemStatusId'];
    $characterItemId = $row['CharacterItemId'];
	$itemId = $row['ItemId'];
    $index = $offset + $i;
		
    if($row['Quantity']){
		$itemQuantity = $row['Quantity'];
	}
	else {
		$itemQuantity = 0;
	}
	echo "<td><input type='number' min='0' max='9999999' name='item[{$index}][quantity]' value='{$itemQuantity}'></input></td>";
    echo "<td>";
    html_listbox("item[{$index}][transferDestination]", $itemStatusOptions, $transferSource);        
    echo "</td>";
    echo "<td><input type='number' min='0' max='{$itemQuantity}' name='item[{$index}][transferQuantity]' value='0'></input></td>";
    
    echo "<td><input type='hidden' min='0' max='9999999' name='item[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    echo "<td><input type='hidden' min='0' max='9999999' name='item[{$index}][itemId]' value='{$itemId}'></input></td>";
    echo "<td><input type='hidden' min='0' max='9999999' name='item[{$index}][characterItemId]' value='{$characterItemId}'></input></td>";     
    echo "</tr>\n";
}
echo "</table>\n";
echo "<hr/>\n";
echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";

//end tag for scrollable div
echo "</div>\n";

?>

</form>
</body>
</html>