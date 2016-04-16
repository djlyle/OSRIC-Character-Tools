<?php
/**
  *  Author: Daniel Lyle
  *  Copyright: June 5,2015
  *  Program: editcharacter.php
  *  Desc: Edits an existing character or adds a new character to the Characters table in the osric_db
**/

$characterId = $_GET['CharacterId'];

include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");
require_once(dirname(__FILE__)."/inc/OsricHtmlHelper.php");


$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
if($characterId != -1)
{
	$character = $myOsricDb->getCharacter($characterId);
}
$labels = array("CharacterName"=>"Name","CharacterGender"=>"Gender","CharacterAge"=>"Age (years)","CharacterWeight"=>"Weight (lbs)","CharacterHeight"=>"Height (inches)","RaceId"=>"Race");
$inputTypes = array("CharacterName"=>"text","CharacterGender"=>"select","CharacterAge"=>"float","CharacterWeight"=>"float","CharacterHeight"=>"float","RaceId"=>"select");
$selectOptions['CharacterGender'][0] = "Unknown";
$selectOptions['CharacterGender'][1] = "Male";
$selectOptions['CharacterGender'][2] = "Female";
$selectOptions['RaceId'] = $myOsricDb->getRaceOptions();

?>
<html>
<head>
<title>Edit Character</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<div id='CharacterTraits'>
<?php
echo "<div class='clsTitle'>Character Traits for {$character['CharacterName']}:</div>\n";
echo "<form class='clsOsricForm' action='submitcharacter.php' method='post'>\n";
echo "<input type='hidden' name='CharacterId' value='$characterId'/>";
echo "<table>\n";
foreach($labels as $field => $label)
{
	echo "<tr>";
	echo "<td>";
	echo "<label for='$field'>$label</label>";
	echo "</td>";
	if($characterId != -1)
	{
		$value = $character[$field];	
	}
	else
	{
		$value = "";	
	}
	echo "<td>";
	$inputType = $inputTypes[$field];
	switch($inputType)
	{
		case "text":
			echo "<input type='text' name='$field' value='$value'/>";
		break;
		case "select":
            OsricHtmlHelper::html_listbox($field, $selectOptions[$field], $value);
		break;
		case "float":
			echo "<input type='number' name='$field' min='0' step='any' value='$value'/>";
		break;
	}
	echo "</td>";
	echo "</tr>\n";
}
echo "</table>\n";
?>
<div class='clsSubmitBtnsDiv' id="submit">
	<input type="submit" value="Submit Character"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</div>
</body>
</html>	