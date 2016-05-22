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
	$character_traits = $myOsricDb->getCharacterTraits($characterId);
}

?>
<html>
<head>
<title>Edit Character</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<div id='CharacterTraits'>
<?php
$character_name = $character['CharacterName'];
echo "<div class='clsTitle'>Character Traits for {$character_name}:</div>\n";
echo "<form class='clsOsricForm' action='submitcharacter.php' method='post'>\n";
echo "<input type='hidden' name='CharacterId' value='$characterId'/>\n";
echo "<table class='clsPropertiesTbl'>\n";
echo "<tr><td>Name:</td><td><input type='text' name='CharacterName' value='{$character_name}'></input></td></tr>\n";
OsricHtmlHelper::makeHtmlTableRowsForCharacterTraits($character_traits,$myOsricDb);
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