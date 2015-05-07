<?php
/*Program:editCharacterInventory.php
 *Desc: Edits character's existing inventory
 */
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
include("./inc/characterInventory.inc");
$characterId = $_REQUEST['CharacterId'];
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$character = getCharacter($cxn,$characterId);
$characterName = $character['CharacterName'];

$armourRows = $_POST['armour'];
foreach($armourRows as $armourRow)
{
    /*$result = updateCharacterArmour($cxn, $armourRow['characterArmourId'], $armourRow['quantity'], $armourRow['armourMagic'], $armourRow['equipmentStatusId']);*/
    if($armourRow['transferQuantity'] > 0)
    {
        $result = osricdb_transferCharacterArmour($cxn, $characterId, $armourRow);
    }
}
/*Delete any armour rows whose quantity is now zero*/
osricdb_removeZeroQuantityArmourRows($cxn);
/*Delete any armour rows whose equipment status is now discarded*/
osricdb_removeDiscardedArmourRows($cxn);


$weaponRows = $_POST['weapon'];
foreach($weaponRows as $weaponRow)
{
    /*$result = updateCharacterWeapons($cxn, $weaponRow['characterWeaponId'], $weaponRow['quantity'], $weaponRow['weaponMagic'], $weaponRow['equipmentStatusId']);*/
    if($weaponRow['transferQuantity'] > 0)
    {
        $result = osricdb_transferCharacterWeapons($cxn, $characterId, $weaponRow);
    }
}
/*Delete any weapon rows whose quantity is now zero*/
osricdb_removeZeroQuantityWeaponRows($cxn);
/*Delete any weapon rows whose equipment status is now discarded*/
osricdb_removeDiscardedWeaponRows($cxn);

$coinRows = $_POST['coin'];
/*First update quantities for all rows before transferring quantities between storage, carried or discarded.  Otherwise the updated quantity
  will override any amounts that have been transferred*/
foreach($coinRows as $coinRow)
{
    $result = osricdb_updateCharacterCoins($cxn, $coinRow['characterCoinId'], $coinRow['quantity']);
}

foreach($coinRows as $coinRow)
{        
    if($coinRow['transferQuantity'] > 0)
    {
        $result = osricdb_transferCharacterCoins($cxn, $characterId, $coinRow);
    }
}
/*Delete any coin rows whose quantity is now zero*/
osricdb_removeZeroQuantityCoinRows($cxn);
/*Delete any coin rows whose equipment status is now discarded*/
osricdb_removeDiscardedCoinRows($cxn);

$itemRows = $_POST['item'];
foreach($itemRows as $itemRow)
{
    if($itemRow['transferQuantity'] > 0)
    {
        $result = osricdb_transferCharacterItems($cxn, $characterId, $itemRow);
    }
}
/*Delete any item rows whose quantity is now zero*/
osricdb_removeZeroQuantityItemRows($cxn);
/*Delete any item rows whose item status is now discarded*/
osricdb_removeDiscardedItemRows($cxn);


?>
<html>
<head>
<title>
<?php 
echo "Updating {$characterName}'s inventory"; 
?>
</title
</head>
<body>
<?php
echo "<p>{$characterName}'s inventory has been updated.</p>";
echo "<a href=\"equipcharacter.php?CharacterId={$characterId}\">Return to character's inventory.</a>";
?>
</body>
</head>