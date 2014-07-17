<?php
/*Program:editCharacterInventory.php
 *Desc: Edits character's existing inventory
 */
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
include("./inc/characterInventory.inc");
$characterId = $_REQUEST['CharacterId'];
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$character = getCharacter($cxn,$characterId);
$characterName = $character['CharacterName'];
$editedItemTag = "editedItem";
$editedItemTagLen = strlen($editedItemTag);
foreach($_POST as $field => $value)
{
	/*Check if the name of the element in the POST array begins with "editedItem".  If it does then
	   insert its value into the character_items table using the passed over characterId*/
	
	if(strpos($field,$editedItemTag) === 0)
	{
		/*extract itemId from $field name, e.g. if $field="editedItem3" then itemId == 3*/
		$itemIdLen = strlen($field) - $editedItemTagLen;
		$itemId = substr($field,$editedItemTagLen,$itemIdLen);
		$itemQuantity = trim($value);
		
		$result = updateCharacterItems($cxn, $characterId, $itemId, $itemQuantity);
	}
}
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
echo "<a href=\"equipcharacter.php?CharacterId={$characterId}\">Return to character's inventory.</a>";
?>
</body>
</head>