<?php
include("./inc/misc.inc");
include("./inc/characterInventory.inc");
include("./inc/charactertblfuncs.inc");
$characterId = $_REQUEST['CharacterId'];
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$character = getCharacter($cxn,$characterId);
$characterName = $character['CharacterName'];
$totalItemEncumbrance = getTotalItemEncumbrance($cxn,$characterId);
$totalCoinEncumbrance = getTotalCoinEncumbrance($cxn,$characterId);
$totalEncumbrance = $totalItemEncumbrance + $totalCoinEncumbrance;
$totalValue = getTotalCost($cxn,$characterId);
?>

<html>
<header><title><?php echo "{$characterName}'s Equipment List"; ?></title></header>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
<body>
<form action="editCharacterInventory.php" method="POST">

<?php
echo "<h3>{$characterName}</h3>";
echo "Total Encumbrance: ";
echo "{$totalEncumbrance} (gp in weight)";
echo "<br/>";
echo "Total Value: ";
$totalValueStr = sprintf("%01.2f",$totalValue);
echo "{$totalValueStr} (gp in value)";
echo "<br/><br/>";
echo "<a href='characters.php'>Return to list of characters</a>";
echo "<hr/>";
echo "<h3>Coins:</h3>";
echo "<div><input type='submit' value='submit coin inventory'/></div>";
echo "<table id='osric_character_coins'>";
echo "<tr><td>Coin Name</td><td>Quantity</td></tr>";
$query = "SELECT * FROM character_coins cc INNER JOIN coins c on cc.CoinId = c.CoinId WHERE cc.CharacterId = $characterId";
$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
while($row = mysqli_fetch_assoc($result))
{
    echo "<tr>";
    echo "<td>{$row['CoinName']}</td>";
    $coinId = $row['CoinId'];
	if($row['Quantity']){
		$coinQuantity = $row['Quantity'];
	}
	else {
		$coinQuantity = 0;
	}
	echo "<td><input type='number' min='0' max='9999999' name='editedCoin{$coinId}' value='{$coinQuantity}'></input></td>";    
    echo "</tr>";
}
echo "</table>";
echo "<hr/>";

echo "<h3>Equipment:</h3>";
echo "<p>To add equipment not yet in this character's inventory or to supplement this character's existing inventory click on the \"Select new equipment\" link.  The quantities selected from that list will be added to the character's existing inventory.</p>";

echo "<p>To edit existing inventory amounts, goto the row in question in the character's equipment inventory table below and edit the quantity of items possessed by the character to whatever is desired.  Then click the \"submit equipment list\" button to submit the edited quantities and save them in the database.</p>";

echo "<div><a href='selectequipment.php?CharacterId={$characterId}'>Select new equipment</a></div>";
echo "<br/>";
echo "<div><input type='submit' value='submit equipment list'/></div>";
echo "<table id='osric_character_equipment'>";
echo "<tr><td>Item Name</td><td>Encumbrance (gp)</td><td>Cost (gp)</td><td>Quantity</td></tr>";
$query = "SELECT * FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = $characterId";
$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
$itemQuantity = 0;
while($row = mysqli_fetch_assoc($result))
{
	echo "<tr>";
	echo "<td>{$row['ItemName']}</td>";
	echo "<td>{$row['ItemEncumbrance']}</td>";
	echo "<td>{$row['ItemCost']}</td>";
	$itemId = $row['ItemId'];
	if($row['Quantity']){
		$itemQuantity = $row['Quantity'];
	}
	else {
		$itemQuantity = 0;
	}
	echo "<td><input type='number' min='0' max='9999999' name='editedItem{$itemId}' value='{$itemQuantity}'></input></td>";
	echo "</tr>";
}
echo "</table>";
echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";

?>

</form>
</body>
</html>