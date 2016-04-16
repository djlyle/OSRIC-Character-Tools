<?php
/*
  Author: Daniel Lyle
  Copyright: June 4,2015
  Program: editcharacterclasses.php
 *Desc: Edits an existing character's classes in the osric_db
 */

$characterId = $_GET['CharacterId'];

include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricHtmlHelper.php");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);

?>
<html>
<head>
<title>Edit Character Classes</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<?php
echo "<div class='clsTitle'>Character Classes for {$character['CharacterName']}:</div>\n";
echo "<form class='clsOsricForm' action='submitcharacterclasses.php' method='post'>\n";
echo "<input type='hidden' name='CharacterId' value='$characterId'/>";

$characterClasses = $myOsricDb->getCharacterClasses($characterId);
$classes = $myOsricDb->getClasses();
OsricHtmlHelper::makeHtmlCharacterClasses($classes,$characterClasses);

?>
<div class='clsSubmitBtnsDiv' id="submit">
	<input type="submit" value="Submit Classes"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	