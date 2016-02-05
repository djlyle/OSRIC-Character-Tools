<?php
/*
File: awardtreasureandxp.php
Author: Daniel Lyle
Copyright: June 1,2015
*/
include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");
require_once(dirname(__FILE__)."/inc/OsricHtmlHelper.php");

$characterId = $_REQUEST['CharacterId'];
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
$totalEncumbranceOnPerson = $myOsricDb->getTotalEncumbranceOnPerson($characterId);

?>

<html>
<header><title><?php echo "Award {$characterName} with Treasure:"; ?></title></header>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
<body>
<form action="addToCharacterTreasureAndXP.php" method="POST">

<?php
echo "<h3>{$characterName}</h3>\n";
echo "Total Encumbrance: \n";
echo "{$totalEncumbranceOnPerson} (lbs)";
echo "<br/>\n";
echo "<br/>\n";
echo "<a href='characters.php'>Return to list of characters</a>\n";
echo "<p>Award treasure and experience points using the form below.</p>";
echo "<p>Press the submit button below when ready to finalize any changes.</p>";
echo "<div><input type='submit' value='submit'/></div>\n";
echo "<hr/>\n";
echo "<div id='CharacterInventoryContent' class='clsScrollable'>\n";

//Html form will POST row data via an array.  Each row will be POSTED with a given index.
//If same array name is used in multiple tables then the starting index for that array will
//differ. The variable postArrayIndexOffset is the index to start with for the array used in POSTing the input elements 
//in the rows of the html table in question.

echo "<h3>Award Treasure:</h3>\n";
$coinNamesAndIds = $myOsricDb->getCoinNamesAndIds();
OsricHtmlHelper::makeHtmlTableCoinsTreasure("osric_treasure_coins",$coinNamesAndIds);
echo "<hr/>\n";
echo "<h3>Award Experience Points (XP):</h3>\n";
OsricHtmlHelper::makeHtmlTableExperiencePoints("osric_treasure_xp");
echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";

?>

</form>
</body>
</html>
