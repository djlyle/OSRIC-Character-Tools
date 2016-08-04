<?php
/*Program:editCharacterInventory.php
 *Desc: Edits character's existing inventory
 */
include_once("./inc/misc.inc");
require_once("./inc/OsricDb.php");
$characterId = $_REQUEST['CharacterId'];
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$characterName = $character['CharacterName'];

$coinRows = $_POST['coin'];
$transferDestination = $_POST['transferDestination'];

/*First update quantities for all rows before transferring quantities between storage, carried or discarded.  Otherwise the updated quantity
  will override any amounts that have been transferred*/
foreach($coinRows as $coinRow)
{
    $result = $myOsricDb->updateCharacterCoins($coinRow['characterCoinId'], $coinRow['quantity']);
}

foreach($coinRows as $coinRow)
{        
    if($coinRow['transferQuantity'] > 0)
    {
        $result = $myOsricDb->transferCharacterCoins($characterId, $coinRow, $transferDestination);
    }
}
/*Delete any coin rows whose quantity is now zero*/
$myOsricDb->removeZeroQuantityCoinRows();
/*Delete any coin rows whose equipment status is now discarded*/
$myOsricDb->removeDiscardedCoinRows();

$itemRows = $_POST['item'];
foreach($itemRows as $itemRow)
{
    if($itemRow['transferQuantity'] > 0)
    {
        $result = $myOsricDb->transferCharacterItems($characterId, $itemRow, $transferDestination);
    }
}
/*Delete any item rows whose quantity is now zero*/
$myOsricDb->removeZeroQuantityItemRows();
/*Delete any item rows whose item status is now discarded*/
$myOsricDb->removeDiscardedItemRows();


?>
<html>
<head>
<title>
<?php 
echo "Updating {$characterName}'s inventory"; 
?>
</title
</head>
<body>
<?php
echo "<p>{$characterName}'s inventory has been updated.</p>";
echo "<a href=\"characterinventory.php?CharacterId={$characterId}\">Return to character's inventory.</a>";
?>
</body>
</head>