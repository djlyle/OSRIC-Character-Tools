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
	foreach($itemRows as $itemRow)
	{
		$itemId = $itemRow['itemId'];
		$quantityToAdd = $itemRow['quantity'];
		echo "Items to add:";
		echo "<br/>";
		if($quantityToAdd > 0)
		{
			$quantityToAdd = $itemRow['quantity'];
			echo "Item id: '{$itemId}'";
			echo "<br/>";
			$cost = $myOsricDb->getItemCost($itemId);
			echo "Cost: '{$cost}'";
			echo "<br/>";
			$itemTotalCost = $cost * $quantityToAdd;
			$totalCost = $totalCost + $itemTotalCost;
			echo "Quantity: '{$quantityToAdd}'";
			echo "<br/>";
			echo "Total cost: '{$itemTotalCost}'}";
			echo "<br/>";
		}	
	}
	echo "Purchasing all the items will cost this character '{$totalCost}' gold coins"; 
		
	echo "<br/><br/>";
	echo "<a href='characterinventory.php?CharacterId={$characterId}'>Return to character's inventory</a>";
?>
</body>
</html>