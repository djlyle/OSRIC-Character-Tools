<?php
/*Program: editcharacterabilities.php
   Desc: Edits an existing character's abilities in the osric_db*/

$CharacterId = $_GET['CharacterId'];

include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");

$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

$character = getCharacter($cxn,$CharacterId);
$characterAbilities = getCharacterAbilities($cxn,$CharacterId);
echo "Character Abilities for {$character['CharacterName']} (CharacterId={$CharacterId}):";
$labels = array("CharacterAbilityStrength"=>"Strength","CharacterAbilityDexterity"=>"Dexterity","CharacterAbilityConstitution"=>"Constitution","CharacterAbilityIntelligence"=>"Intelligence","CharacterAbilityWisdom"=>"Wisdom","CharacterAbilityCharisma"=>"Charisma");
$inputTypes = array("CharacterAbilityStrength"=>"float","CharacterAbilityDexterity"=>"float","CharacterAbilityConstitution"=>"float","CharacterAbilityIntelligence"=>"float","CharacterAbilityWisdom"=>"float","CharacterAbilityCharisma"=>"float");
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
echo "<input type='hidden' name='CharacterId' value='$CharacterId'/>";
echo "<table>";
foreach($labels as $field => $label)
{
	echo "<tr>";
	echo "<td>";
	echo "<label for='$field'>$label</label>";
	echo "</td>";
	$value = $characterAbilities[$field];	
	echo "<td>";
	$inputType = $inputTypes[$field];
	switch($inputType)
	{
		case "float":
			echo "<input type='number' name='$field' min='0' step='any' value='$value'/>";
		break;
	}
	echo "</td>";
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