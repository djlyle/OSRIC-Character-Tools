<?php
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
$characterId = $_REQUEST['CharacterId'];
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$character = getCharacter($cxn,$characterId);
$characterName = $character['CharacterName'];
?>
<html>
<header><title>Equipment List</title></header>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
<body>
<form action="addToCharacterInventory.php" method="POST">
<?php

echo "<h3>Equipment to add to {$characterName}'s inventory:</h3>";
echo "<input type='submit' value='submit'>";
echo "<table id='osric_equipment_not_carried'>";
$query = "SELECT * FROM items";
$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
echo "<tr><td>Item Name</td><td>Encumbrance (gp)</td><td>Cost (gp)</td><td>Quantity</td><td></td></tr>";
$i = 0;
while($row = mysqli_fetch_assoc($result))
{
 	echo "<tr>";
	echo "<td>{$row['ItemName']}</td>";
	echo "<td>{$row['ItemEncumbrance']}</td>";
	echo "<td>{$row['ItemCost']}</td>";
	$itemId = $row['ItemId'];
    echo "<td><input type='number' min='0' max='9999999' name='item[{$i}][quantity]' value='0'></input></td>";
    echo "<td><input type='hidden' name='item[{$i}][itemId]' value='{$itemId}'></input></td>";
	echo "</tr>";
    $i = $i + 1;	
}
echo "</table>";
echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";
?>
</form>
</body>
</html>