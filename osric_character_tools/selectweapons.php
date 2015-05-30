<?php
include_once("./inc/misc.inc");
include_once("./inc/charactertblfuncs.inc");
require_once("./inc/OsricDb.php");
$characterId = $_REQUEST['CharacterId'];
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
?>
<html>
<header><title>Weapons List</title></header>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
<body>
<form action="addToCharacterWeapons.php" method="POST">
<?php

echo "<h3>Weapons to add to {$characterName}'s inventory:</h3>";
echo "<input type='submit' value='submit'>";
$weapons = $myOsricDb->getWeapons();
echo "<table id='osric_weapons'>";
echo "<tr><td>Weapon Type</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td></tr>";
$i = 0;
$num_rows = count($weapons);
for($i=0;$i<$num_rows;$i++)
{
	$row = $weapons[$i];

	echo "<tr>";
	echo "<td>{$row['WeaponType']}</td>";
	echo "<td>{$row['WeaponEncumbranceInLbs']}</td>";
	echo "<td>{$row['WeaponCost']}</td>";
	$weaponId = $row['WeaponId'];
	echo "<td><input type='number' min='0' max='9999999' name='weapon[{$i}][quantity]' value='0'></input></td>";
	echo "<td><input type='hidden' name='weapon[{$i}][weaponId]' value='{$weaponId}'></input></td>";
	echo "</tr>";
	$i = $i + 1;	
}
echo "</table>";
echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";
?>
</form>
</body>
</html>