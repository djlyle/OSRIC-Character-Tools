<?php
/*Program: addToCharacterInventory.php
   Desc: Adds items to character's inventory
*/
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
require_once("./inc/OsricDb.php");
$characterId = $_REQUEST['CharacterId'];
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$characterName = $character['CharacterName'];
$itemRows = $_POST['item'];
foreach($itemRows as $itemRow)
{
    $itemId = $itemRow['itemId'];
    if($itemId != -1)
    {
		/*Check if item is already in character's inventory.  If it is
		   then get the count of that item in the character's inventory and
		   update it to be the sum of the value submitted to the existing
		   number.  If it isn't yet in the character's inventory then
		   insert it as a new row in the character's inventory.*/ 
		$query = "SELECT * FROM character_items ci WHERE ci.CharacterId = '{$characterId}' AND ci.ItemId = '{$itemId}'";
		/*echo $query;*/
		$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
		$row = mysqli_fetch_assoc($result);
		if($row)
		{
			/*item found in existing inventory.  Update it's count to be its existing count plus the count just added.*/
			$count = $row['Quantity'] + $itemRow['quantity'];
			if($count > 0)
			{
				$query = "UPDATE character_items SET Quantity = '{$count}' WHERE CharacterId = '{$characterId}' AND ItemId = '{$itemId}'";
				$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
			}
		}
		else
		{
			/*item not found in existing inventory.  Insert it as a new row in the character's inventory.*/
			$count = $itemRow['quantity'];
			if($count > 0)
			{
				$query = "INSERT INTO character_items (`CharacterId`, `ItemId`, `Quantity`) VALUES ('{$characterId}', '{$itemId}', '{$count}')"; 
				$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");	
			}
		}
		
	}
}
?>

<html>
<head><title>Items Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Inventory Updated.";
	echo "<br/><br/>";
	echo "<a href='equipcharacter.php?CharacterId={$characterId}'>Return to character's equipment list</a>";
?>
</body>
</html>