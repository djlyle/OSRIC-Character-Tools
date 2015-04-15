<?php
/*Program: addToCharacterInventory.php
   Desc: Adds items to character's inventory
*/
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
$characterId = $_REQUEST['CharacterId'];
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$character = getCharacter($cxn,$characterId);
$characterName = $character['CharacterName'];
$weaponRows = $_POST['weapon'];
foreach($weaponRows as $weaponRow)
{
    $weaponId = $weaponRow['weaponId'];
    if($weaponId != -1)
    {
		/*Check if weapon is already in character's inventory.  If it is
		   then get the count of that weapon in the character's inventory and
		   update it to be the sum of the value submitted to the existing
		   number.  If it isn't yet in the character's inventory then
		   insert it as a new row in the character's inventory.*/ 
		$query = "SELECT * FROM character_weapons cw WHERE cw.CharacterId = '{$characterId}' AND cw.WeaponId = '{$weaponId}'";
		$result = mysqli_query($cxn,$query) or die("Couldn't execute select character_weapons query.");
		$row = mysqli_fetch_assoc($result);
		if($row)
		{
			/*weapon found in existing inventory.  Update it's count to be its existing count plus the count just added.*/
			$count = $row['Quantity'] + $weaponRow['quantity'];
			if($count > 0)
			{
				$query = "UPDATE character_weapons SET Quantity = '{$count}' WHERE CharacterId = '{$characterId}' AND WeaponId = '{$weaponId}'";
				$result = mysqli_query($cxn,$query) or die("Couldn't execute update character_weapons query.");
			}
		}
		else
		{
			/*weapon not found in existing inventory.  Insert it as a new row in the character's inventory.*/
			$count = $weaponRow['quantity'];
			if($count > 0)
			{
				$query = "INSERT INTO character_weapons (`CharacterId`, `WeaponId`, `Quantity`) VALUES ('{$characterId}', '{$weaponId}', '{$count}')"; 
				$result = mysqli_query($cxn,$query) or die("Couldn't execute insert into character_weapons query.");	
			}
		}
	}
}
?>

<html>
<head><title>Weapons Added to <?php echo "{$characterName}'s Inventory"; ?></title></head>
<body>
<?php 
	echo "{$characterName}'s Inventory Updated.";
	echo "<br/><br/>";
	echo "<a href='equipcharacter.php?CharacterId={$characterId}'>Return to character's equipment list</a>";
?>
</body>
</html>