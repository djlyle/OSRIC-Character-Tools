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
    echo "armourRow[quantity]: {$armourRow['quantity']}";
    echo "armourRow[armourId]: {$armourRow['armourId']}";
    echo "armourRow[armourMagic]: {$armourRow['armourMagic']}";
    $result = updateCharacterArmour($cxn, $characterId, $armourRow['armourId'], $armourRow['quantity'], $armourRow['armourMagic']);
}

foreach($_POST as $field => $value)
{
    $quantity = trim($value);
	
    $coinId = getFieldId($field,"editedCoin");
    if($coinId != -1)
    {
        $result = updateCharacterCoins($cxn, $characterId, $coinId, $quantity);    
    }
	
	$itemId = getFieldId($field,"editedItem");    	
	if($itemId != -1)
	{
		/*extract itemId from $field name, e.g. if $field="editedItem3" then itemId == 3*/	
		$result = updateCharacterItems($cxn, $characterId, $itemId, $quantity);
    }
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