<?php
/*Program: addToCharacterArmour.php
   Desc: Adds armour to character's inventory
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
$armourRows = $_POST['armour'];
$num_rows = count($armourRows);
foreach($armourRows as $armourRow)
{
    $armourId = $armourRow['armourId'];
    if($armourId != -1)
    {

		/*Check if armour is already in character's inventory.  If it is
		   then get the count of that item in the character's inventory and
		   update it to be the sum of the value submitted to the existing
		   number.  If it isn't yet in the character's inventory then
		   insert it as a new row in the character's inventory.*/ 
		$query = "SELECT * FROM character_armour ca WHERE ca.CharacterId = '{$characterId}' AND ca.ArmourId = '{$armourId}'";
		$result = mysqli_query($cxn,$query) or die("Couldn't execute select character_armour query.");
		$row = mysqli_fetch_assoc($result);
		if($row)
		{
			/*item found in existing inventory.  Update it's count to be its existing count plus the count just added.*/
			$count = $row['Quantity'] + $armourRow['quantity'];
			if($count > 0)
			{
				$query = "UPDATE character_armour SET Quantity = '{$count}' WHERE CharacterId = '{$characterId}' AND ArmourId = '{$armourId}'";
                $result = mysqli_query($cxn,$query) or die("Couldn't execute update character_armour query.");
			}
		}
		else
		{
			/*item not found in existing inventory.  Insert it as a new row in the character's inventory.*/
			$count = $armourRow['quantity'];
			if($count > 0)
			{
				$query = "INSERT INTO character_armour (`CharacterId`, `ArmourId`, `Quantity`) VALUES ('{$characterId}', '{$armourId}', '{$count}')"; 
                $result = mysqli_query($cxn,$query) or die("Couldn't execute insert into character_armour query.");	
			}
		}
		
	}
}
?>

<html>
<head><title>Armour Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Inventory Updated.";
	echo "<br/><br/>";
	echo "<a href='equipcharacter.php?CharacterId={$characterId}'>Return to character's equipment list</a>";
?>
</body>
</html>