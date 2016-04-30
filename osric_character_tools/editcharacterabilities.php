<?php
/*Program: editcharacterabilities.php
   Desc: Edits an existing character's abilities in the osric_db*/

include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");
require_once(dirname(__FILE__)."/inc/OsricHtmlHelper.php");

$characterId = $_GET['CharacterId'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);

?>

<!-- Character form -->
<html>
<head>
<title>Edit Character Abilities</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>

<?php
echo "<div class='clsTitle'>Character Abilities for {$character['CharacterName']}:</div>\n";
echo "<form class='clsOsricForm' action='submitcharacterabilities.php' method='post'>\n";
echo "<input type='hidden' name='CharacterId' value='$characterId'/>";
$character_abilities = $myOsricDb->getCharacterAbilities($characterId);
OsricHtmlHelper::makeHtmlTableCharacterAbilities($character_abilities);
?>
<div id="submit">
	<input type="submit" value="Submit Abilities"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	