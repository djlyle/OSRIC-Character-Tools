<?php
/*
File: selectequipment.php
Author: Daniel Lyle
Copyright: June 17,2015
*/

include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricHtmlHelper.php");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$characterId = $_REQUEST['CharacterId'];

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];
?>
<html>
<header><title>Equipment List</title></header>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
<body>
<form action="confirmPurchase.php" method="POST">
<?php
echo "<h3>{$characterName}</h3>\n";
echo "<br/>";
echo "<a href='characters.php'>Return to list of characters</a>\n";
echo "<p>Select items to purchase and add to your inventory.</p>";
echo "<p>Press the submit button below when ready to finalize any changes.</p>";
echo "<input type='submit' value='submit'>";
echo "<hr/>\n";

echo "<div id='PurchaseableInventoryContent' class='clsScrollable'>\n";
echo "<h3>Armour:</h3>\n";
$postArrayIndexOffset = 0;
$items = $myOsricDb->getItemsByItemType(1);
$num_rows = count($items);
OsricHtmlHelper::makeHtmlTableItemsToPurchase($items, "osric_items_to_purchase_armour", $postArrayIndexOffset);
$postArrayIndexOffset = $postArrayIndexOffset + $num_rows;
echo "<hr/>\n";
echo "<h3>Weapons:</h3>\n";
$items = $myOsricDb->getItemsByItemType(2);
$num_rows = count($items);
OsricHtmlHelper::makeHtmlTableItemsToPurchase($items, "osric_items_to_purchase_weapons", $postArrayIndexOffset);
$postArrayIndexOffset = $postArrayIndexOffset + $num_rows;
echo "<hr/>\n";
echo "<h3>Equipment:</h3>\n";
$items = $myOsricDb->getItemsByItemType(0);
OsricHtmlHelper::makeHtmlTableItemsToPurchase($items, "osric_items_to_purchase_equipment", $postArrayIndexOffset);

echo "<input type='hidden' name='CharacterId' value='{$characterId}'/>";
echo "</div>";
?>
</form>
</body>
</html>