<?php
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
$characterId = $_REQUEST['CharacterId'];
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$character = getCharacter($cxn,$characterId);
$characterName = $character['CharacterName'];
?>
<html>
<header><title>Armour List</title></header>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
<body>
<form action="addToCharacterArmour.php" method="POST">
<?php

echo "<h3>Armour to add to {$characterName}'s inventory:</h3>";
echo "<input type='submit' value='submit'>";
echo "<table id='osric_armour'>";
$query = "SELECT * FROM armour";
$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
echo "<tr><td>Armour Type</td><td>Encumbrance (gp)</td><td>Movement Rate</td><td>Effect on Armour Class</td><td>Cost (gp)</td><td>Quantity</td><td></td></tr>";
$i = 0;
while($row = mysqli_fetch_assoc($result))
{
 	echo "<tr>";
	echo "<td>{$row['ArmourType']}</td>";
	echo "<td>{$row['ArmourEncumbrance']}</td>";
	echo "<td>{$row['ArmourCost']}</td>";
    echo "<td>{$row['ArmourEffectOnArmourClass']}</td>";
    echo "<td>{$row['ArmourCost']}</td>";
	$armourId = $row['ArmourId'];
	echo "<td><input type='number' min='0' max='9999999' name='armour[{$i}][quantity]' value='0'></input></td>";
    echo "<td><input type='hidden' name='armour[{$i}][armourId]' value='{$armourId}'></input></td>";
	echo "</tr>";
    $i = $i + 1;	
}
echo "</table>";
echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";
?>
</form>
</body>
</html>