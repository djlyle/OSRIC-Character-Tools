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
<head><title>Confirm Purchase for <?php echo "{$characterName}"?></title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<?php

$totalCost = 0;
echo "Items selected for purchase:";
echo "<br/>\n";
echo "<table id='itemsSelectedForPurchase'>\n";
echo "<tr><td>Item name</td><td>Cost</td><td>Quantity</td><td>Total Cost</td></tr>\n";				
foreach($itemRows as $itemRow)
{
	$itemId = $itemRow['itemId'];
	$quantityToAdd = $itemRow['quantity'];
	if($quantityToAdd > 0)
	{
		$item = $myOsricDb->getItem($itemId);
		$itemName = $item['ItemName'];
		$cost = $myOsricDb->getItemCost($itemId);
		$itemTotalCost = bcmul($cost,$quantityToAdd, 2);//$itemTotalCost = $cost * $quantityToAdd;
		$totalCost = bcadd($totalCost, $itemTotalCost, 2);//$totalCost = $totalCost + $itemTotalCost;
				
		echo "<tr>";
		echo "<td>'{$itemName}'</td>";
		echo "<td>'{$cost}'</td>";
		echo "<td>'{$quantityToAdd}'</td>";
		echo "<td>'{$itemTotalCost}'</td>";
		echo "</tr>\n";
	}	
}
echo "</table>\n";
echo "<hr/>\n";
echo "<p>Purchasing all these items will cost '{$totalCost}' gold coins.</p>"; 
$characterPurchasePower = $myOsricDb->getStoredCoinsValueInGoldCoins($characterId);

echo "<p>Character currently has the equivalent of '{$characterPurchasePower}' gold coins in storage.</p>"; 
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
//echo "<table>";
$index = 0;
foreach($itemRows as $itemRow)
{
	$itemId = $itemRow['itemId'];
	$quantityToAdd = $itemRow['quantity'];
	if($quantityToAdd > 0)
	{
		//echo "<tr>\n";
		//echo "<td>";
		echo "<input type='hidden' name='item[{$index}][quantity]' value='{$quantityToAdd}'></input>\n";
		//echo "</td>";
		//echo "<td>";
		echo "<input type='hidden' name='item[{$index}][itemId]' value='{$itemId}'></input>\n";
		//echo "</td>\n";
		//echo "</tr>\n";
		$index = $index + 1;
	}
}
//echo "</table>";			
echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";
echo "<a href='characters.php'>Return to list of characters</a>\n";
?>
</form>
</body>
</html>