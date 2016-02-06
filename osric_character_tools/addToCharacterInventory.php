<?php
/*
File: addToCharacterInventory.php
Author: Daniel Lyle
Copyright: June 17, 2015
Desc: Adds items to character's inventory
*/
include(dirname(__FILE__)."/inc/misc.inc");
require_once("./inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];
$itemRows = $_POST['item'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);

foreach($itemRows as $itemRow)
{
		$itemId = $itemRow['itemId'];
		$quantityToAdd = $itemRow['quantity'];
		//TODO: this doesn't seem to work yet for weapons and armour
		$myOsricDb->addToCharacterItems($characterId,$itemId,$quantityToAdd);
}

$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
?>

<html>
<head><title>Items Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Inventory Updated.";
	$totalCost = 0;
	echo "Items to add:";
	echo "<br/>";
		
	foreach($itemRows as $itemRow)
	{
		$itemId = $itemRow['itemId'];
		$quantityToAdd = $itemRow['quantity'];
		if($quantityToAdd > 0)
		{
			$quantityToAdd = $itemRow['quantity'];
			echo "Item id: '{$itemId}'";
			echo "<br/>";
			$cost = $myOsricDb->getItemCost($itemId);
			echo "Cost: '{$cost}'";
			echo "<br/>";
			$itemTotalCost = bcmul($cost,$quantityToAdd, 2);//$itemTotalCost = $cost * $quantityToAdd;
			$totalCost = bcadd($totalCost, $itemTotalCost, 2);//$totalCost = $totalCost + $itemTotalCost;
			echo "Quantity: '{$quantityToAdd}'";
			echo "<br/>";
			echo "Total cost: '{$itemTotalCost}'}";
			echo "<br/><br/>";
		}	
	}
	echo "Purchasing all the items will cost this character '{$totalCost}' gold coins"; 
		
	echo "<br/><br/>";
	echo "<a href='characterinventory.php?CharacterId={$characterId}'>Return to character's inventory</a>";
?>
</body>
</html>