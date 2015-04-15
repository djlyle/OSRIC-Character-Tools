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
echo "<h3>{$characterName}</h3>\n";
echo "Total Encumbrance: \n";
echo "{$totalEncumbrance} (gp in weight)";
echo "<br/>\n";
echo "Total Value: \n";
$totalValueStr = sprintf("%01.2f",$totalValue);
echo "{$totalValueStr} (gp in value)";
echo "<br/>\n<br/>\n";
echo "<a href='characters.php'>Return to list of characters</a>\n";
echo "<hr/>\n";
echo "<h3>Coins:</h3>\n";
echo "<div><input type='submit' value='submit coin inventory'/></div>\n";
echo "<table id='osric_character_coins'>\n";
echo "<tr><td>Coin Name</td><td>Quantity</td></tr>\n";
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
    echo "</tr>\n";
}
echo "</table>\n";
echo "<hr/>\n";
echo "<h3>Armour:</h3>\n";
echo "<p>To add armour not yet in this character's inventory or to supplement this character's existing inventory click on the \"Select new armour\" link.  The quantities selected from that list will be added to the character's existing inventory.</p>\n";
echo "<p>To edit existing armour amounts, goto the row in question in the character's armour inventory table below and edit the quantity of items possessed by the character to whatever is desired.  Then click the \"submit armour\" button to submit the edited quantities and save them in the database.</p>\n";
echo "<div><a href='selectarmour.php?CharacterId={$characterId}'>Select new armour</a></div>";
echo "<br/>\n";
echo "<div><input type='submit' value='submit armour'/></div>\n";
echo "<table id='osric_character_armour'>\n";
echo "<tr><td>Armour Type</td><td>Effect on Armour Class</td><td>Encumbrance</td><td>Movement Rate</td><td>Cost</td><td>Quantity</td><td>Magic</td></tr>\n";
$query = "SELECT * FROM character_armour ca INNER JOIN armour a ON ca.ArmourId = a.ArmourId WHERE ca.CharacterId = $characterId";
$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
$armourQuantity = 0;
$i = 0;
while($row = mysqli_fetch_assoc($result))
{
    echo "<tr>";
	echo "<td>{$row['ArmourType']}</td>";
	echo "<td>{$row['ArmourEffectOnArmourClass']}</td>";
    echo "<td>{$row['ArmourEncumbrance']}</td>";
    echo "<td>{$row['ArmourMovementRate']}</td>";
	echo "<td>{$row['ArmourCost']}</td>";
    $armourId = $row['ArmourId'];
	if($row['Quantity']){
		$armourQuantity = $row['Quantity'];
	}
	else {
		$armourQuantity = 0;
	}
    $armourMagic = $row['ArmourMagic'];
	echo "<td><input type='number' min='0' max='9999999' name='armour[{$i}][quantity]' value='{$armourQuantity}'></input></td>";
    echo "<td><input type='number' min='0' max='9999999' name='armour[{$i}][armourMagic]' value='{$armourMagic}'></input></td>";	
    echo "<td><input type='hidden' min='0' max='9999999' name='armour[{$i}][armourId]' value='{$armourId}'></input></td>";    
    echo "</tr>\n";
    $i = $i + 1;
}
echo "</table>\n";
echo "<hr/>\n";

echo "<h3>Weapons:</h3>";
echo "<p>To add weapons not yet in this character's inventory or to supplement this character's existing inventory click on the \"Select new weapons\" link.  The quantities selected from that list will be added to the character's existing inventory.</p>\n";
echo "<p>To edit existing inventory amounts, goto the row in question in the character's weapon inventory table below and edit the quantity of items possessed by the character to whatever is desired.  Then click the \"submit weapon list\" button to submit the edited quantities and save them in the database.</p>";
echo "<div><a href='selectweapons.php?CharacterId={$characterId}'>Select new weapons</a></div>";
echo "<br/>";
echo "<div><input type='submit' value='submit weapons list'/></div>";
echo "<table id='osric_character_weapons'>";
echo "<tr><td>Weapon Type</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Magic</td></tr>";
$query = "SELECT * FROM character_weapons cw INNER JOIN weapons w ON cw.WeaponId = w.WeaponId WHERE cw.CharacterId = $characterId";
$result = mysqli_query($cxn,$query) or die("Couldn't execute weapons query.");
$weaponQuantity = 0;
$i = 0;
while($row = mysqli_fetch_assoc($result))
{
    echo "<tr>";
	echo "<td>{$row['WeaponType']}</td>";
	echo "<td>{$row['WeaponEncumbranceInLbs']}</td>";
    echo "<td>{$row['WeaponCost']}</td>";
    $weaponId = $row['WeaponId'];
	if($row['Quantity']){
		$weaponQuantity = $row['Quantity'];
	}
	else {
		$weaponQuantity = 0;
	}
    $weaponMagic = $row['WeaponMagic'];
	echo "<td><input type='number' min='0' max='9999999' name='weapon[{$i}][quantity]' value='{$weaponQuantity}'></input></td>";
    echo "<td><input type='number' min='0' max='9999999' name='weapon[{$i}][weaponMagic]' value='{$weaponMagic}'></input></td>";	
    echo "<td><input type='hidden' min='0' max='9999999' name='weapon[{$i}][weaponId]' value='{$weaponId}'></input></td>";    
    echo "</tr>\n";
    $i = $i + 1;
}
echo "</table>\n";
echo "<hr/>\n";

echo "<h3>Equipment:</h3>";
echo "<p>To add equipment not yet in this character's inventory or to supplement this character's existing inventory click on the \"Select new equipment\" link.  The quantities selected from that list will be added to the character's existing inventory.</p>";
echo "<p>To edit existing inventory amounts, goto the row in question in the character's equipment inventory table below and edit the quantity of items possessed by the character to whatever is desired.  Then click the \"submit equipment list\" button to submit the edited quantities and save them in the database.</p>";
echo "<div><a href='selectequipment.php?CharacterId={$characterId}'>Select new equipment</a></div>";
echo "<br/>";
echo "<div><input type='submit' value='submit equipment list'/></div>";
echo "<table id='osric_character_equipment'>";
echo "<tr><td>Item Name</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td></tr>";
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