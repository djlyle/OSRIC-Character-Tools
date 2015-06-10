<?php
/*Program: characters.php
*Desc: Displays list of characters in OSRIC project
*/
?>
<html>
<head>
<title>OSRIC Project characters vs 1.0</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<?php
include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$genderArray = array("Unknown","Male","Female");
?>
<h3>Characters</h3>
<?php
/*Display results in table*/
$characters = $myOsricDb->getCharacters();
echo "<table id='osric_characters'>";
echo "<tr><td>Name</td><td>Traits</td><td>Classes</td><td>Status</td><td>Abilities</td><td>Equip</td><td>Treasure</td><td>Character Sheet</td><td>Delete</td></tr>";
foreach($characters as $character)
{
	$characterId = $character['CharacterId'];
	echo "<tr>";
	echo "<td>{$character['CharacterName']}</td>";
	echo "<td><a href='editcharacter.php?CharacterId={$characterId}'>Edit Traits</a></td>";
	echo "<td><a href='editcharacterclasses.php?CharacterId={$characterId}'>Edit Classes</a></td>";
	echo "<td><a href='editcharacterstatus.php?CharacterId={$characterId}'>Edit Status</a></td>";
	echo "<td><a href='editcharacterabilities.php?CharacterId={$characterId}'>Edit Abilities</a></td>";
	echo "<td><a href='equipcharacter.php?CharacterId={$characterId}'>Equip Character</a></td>";
	echo "<td><a href='awardtreasureandxp.php?CharacterId={$characterId}'>Treasure</td>";	
	echo "<td><a href='charactersheet.php?CharacterId={$characterId}'>Character Sheet</td>";
	echo "<td><a href='deletecharacter.php?CharacterId={$characterId}'>Delete Character</a></td>";
	echo "</tr>";
}
echo "</table>";
echo "<a href='editcharacter.php?CharacterId=-1'>Add New Character</a></td>";
?>
</body>
</html>