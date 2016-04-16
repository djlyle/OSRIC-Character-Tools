<?php
/*
File: confirmPurchase.php
Author: Daniel Lyle
Copyright: February 24, 2016
Desc: Confirm character's purchase of items.
*/
include(dirname(__FILE__)."/inc/misc.inc");
require_once("./inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];
$itemRows = $_POST['item'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
?>

<html>
<head><title>Confirm Purchase for <?php echo "{$characterName}"?></title></head>
<body>
<?php

$totalCost = 0;
echo "Items selected for purchase:";
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
echo "Purchasing all these items will cost '{$totalCost}' gold coins"; 
$characterPurchasePower = $myOsricDb->getStoredCoinsValueInGoldCoins($characterId);

echo "Character currently has the equivalent of '{$characterPurchasePower}' gold coins in storage"; 
?>	
<form action="addToCharacterInventory.php" method="POST">
<?php

if($totalCost < $characterPurchasePower) {
	echo "<p>Press the submit button below to confirm your purchase.</p>";
	echo "<input type='submit' value='Confirm Purchase'>";
}
else 
{
	echo "Sorry, this character doesn't have enough money for this purchase.";
}
echo "<hr/>";
echo "<table>";
$index = 0;
foreach($itemRows as $itemRow)
{
	$itemId = $itemRow['itemId'];
	$quantityToAdd = $itemRow['quantity'];
	if($quantityToAdd > 0)
	{
		echo "<tr>\n";
		echo "<td><input name='item[{$index}][quantity]' value='{$quantityToAdd}'></input></td>\n";
		echo "<td><input name='item[{$index}][itemId]' value='{$itemId}'></input></td>\n";
		echo "</tr>\n";
		$index = $index + 1;
	}
}
echo "</table>";			
echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";
echo "<a href='characters.php'>Return to list of characters</a>\n";
?>
</form>
</body>
</html>