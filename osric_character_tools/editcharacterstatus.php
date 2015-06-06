<?php
/* 
   Program: editcharacterstatus.php
   Desc: Edits an existing character's status in the osric_db
 */

$characterId = $_GET['CharacterId'];

include(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterStatus = $myOsricDb->getCharacterStatus($characterId);
echo "Status for {$character['CharacterName']} (CharacterId={$characterId}):";
$labels = array("CharacterStatusArmourClass"=>"Armor Class","CharacterStatusExperiencePoints"=>"Experience Points","CharacterStatusFullHitPoints"=>"Full Hit Points","CharacterStatusRemainingHitPoints"=>"Remaining Hit Points");
$inputTypes = array("CharacterStatusArmourClass"=>"integer","CharacterStatusExperiencePoints"=>"integer","CharacterStatusFullHitPoints"=>"integer","CharacterStatusRemainingHitPoints"=>"integer");
?>

<!-- Character status form -->
<html>
<head>
<title>Edit Character Status</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<form action='submitcharacterstatus.php' method='post'>
<?php
echo "<input type='hidden' name='CharacterId' value='$characterId'/>";
echo "<table>";
foreach($labels as $field => $label)
{
	echo "<tr>";
	echo "<td>";
	echo "<label for='$field'>$label</label>";
	echo "</td>";
	$value = $characterStatus[$field];	
	echo "<td>";
	$inputType = $inputTypes[$field];
	switch($inputType)
	{
		case "integer":
            echo "<input type='number' min='0' max='999999999' name='$field' value='$value'></input>";
		break;
	}
	echo "</td>";
	echo "</tr>";
}
echo "</table>";
?>
<div id="submit">
	<input type="submit" value="Submit Character Status"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	