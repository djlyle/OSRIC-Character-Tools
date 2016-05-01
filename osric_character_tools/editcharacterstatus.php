<?php
/* 
   Program: editcharacterstatus.php
   Desc: Edits an existing character's status in the osric_db
 */

$characterId = $_GET['CharacterId'];

include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");
require_once(dirname(__FILE__)."/inc/OsricHtmlHelper.php");

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterStatus = $myOsricDb->getCharacterStatus($characterId);
?>

<!-- Character status form -->
<html>
<head>
<title>Edit Character Status</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<?php
echo "<div class='clsTitle'>Character Status for {$character['CharacterName']}:</div>\n";
echo "<form class='clsOsricForm' action='submitcharacterstatus.php' method='post'>\n";
echo "<input type='hidden' name='CharacterId' value='$characterId'/>";
OsricHtmlHelper::makeHtmlTableCharacterStatus($characterStatus);
?>
<div id="submit">
	<input type="submit" value="Submit Character Status"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	