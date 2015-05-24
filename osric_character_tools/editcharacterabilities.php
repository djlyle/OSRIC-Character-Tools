<?php
/*Program: editcharacterabilities.php
   Desc: Edits an existing character's abilities in the osric_db*/

$characterId = $_GET['CharacterId'];

include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
require_once("./inc/OsricDb.php");
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

$character = $myOsricDb->getCharacter($characterId);

echo "Character Abilities for {$character['CharacterName']} (CharacterId={$characterId}):";
?>

<!-- Character form -->
<html>
<head>
<title>Edit Character Abilities</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<form action='submitcharacterabilities.php' method='post'>
<?php
echo "<input type='hidden' name='CharacterId' value='$characterId'/>";
echo "<table>";
$character_abilities = getCharacterAbilities($cxn,$characterId);
$num_abilities = count($character_abilities);
for($i=0;$i<$num_abilities;$i++)
{
    echo "<tr>";
    echo "<td>{$character_abilities[$i]['AbilityLongName']}</td>";
    $abilityId = $character_abilities[$i]['AbilityId'];
	if($character_abilities[$i]['Value']){
		$value = $character_abilities[$i]['Value'];
	}
	else {
		$value = 0;
	}
	echo "<td><input type='number' min='0' max='9999999' name='editedAbility{$abilityId}' value='{$value}'></input></td>";    
    echo "</tr>";
}
echo "</table>";
?>
<div id="submit">
	<input type="submit" value="Submit Abilities"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	