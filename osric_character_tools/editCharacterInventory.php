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
    $result = updateCharacterArmour($cxn, $characterId, $armourRow['armourId'], $armourRow['quantity'], $armourRow['armourMagic'], $armourRow['equipmentStatusId']);
}

$weaponRows = $_POST['weapon'];
foreach($weaponRows as $weaponRow)
{
    $result = updateCharacterWeapons($cxn, $characterId, $weaponRow['weaponId'], $weaponRow['quantity'], $weaponRow['weaponMagic']);
}

$coinRows = $_POST['coin'];
foreach($coinRows as $coinRow)
{
    $result = updateCharacterCoins($cxn, $characterId, $coinRow['coinId'], $coinRow['quantity']);
}

$itemRows = $_POST['item'];
foreach($itemRows as $itemRow)
{
    $result = updateCharacterItems($cxn, $characterId, $itemRow['itemId'], $itemRow['quantity']);
}

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