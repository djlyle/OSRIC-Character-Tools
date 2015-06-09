<?php
include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
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
$armour = $myOsricDb->getArmour();
echo "<table id='osric_armour'>";
echo "<tr><td>Armour Type</td><td>Encumbrance (gp)</td><td>Movement Rate</td><td>Effect on Armour Class</td><td>Cost (gp)</td><td>Quantity</td><td></td></tr>";
$num_rows = count($armour);
for($i=0;$i<$num_rows;$i++)
{
	$row = $armour[$i]; 	
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