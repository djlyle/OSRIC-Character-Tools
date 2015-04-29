<?php
include("./osricdb_constants.inc");

function getTotalItemEncumbrance($cxn, $characterId)
{
	$query = "SELECT SUM(e.TotalItemEncumbrance) AS TotalEncumbrance FROM (SELECT (i.ItemEncumbrance * ci.Quantity) AS TotalItemEncumbrance FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = '{$characterId}') AS e";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute getTotalEncumbrance query.");
	$row = mysqli_fetch_assoc($result);
	return $row['TotalEncumbrance'];
}

function getTotalCoinEncumbrance($cxn, $characterId)
{
    $query = "SELECT SUM(e.TotalCoinEncumbrance) AS TotalEncumbrance FROM (SELECT (c.CoinEncumbranceInLbs * cc.Quantity) AS TotalCoinEncumbrance FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = '{$characterId}') AS e"; 
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getTotalCoinEncumbrance.");
    $row = mysqli_fetch_assoc($result);
    return $row['TotalEncumbrance'];
}

function getTotalCost($cxn, $characterId)
{
	$query = "SELECT SUM(e.TotalItemCost) AS TotalCost FROM (SELECT (ci.Quantity * i.ItemCost) AS TotalItemCost FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = '{$characterId}') AS e";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute getTotalCost query.");
	$row = mysqli_fetch_assoc($result);
	return $row['TotalCost'];
}

function updateCharacterItems($cxn, $characterId, $itemId, $itemQuantity)
{
	$query = "UPDATE character_items SET Quantity = '{$itemQuantity}' WHERE character_items.CharacterId = {$characterId} AND character_items.ItemId = {$itemId}";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterItems query.");
	return $result;
}



function updateCharacterCoins($cxn, $characterId, $coinId, $coinQuantity)
{
    $query = "UPDATE character_coins SET Quantity = '{$coinQuantity}' WHERE character_coins.CharacterId = {$characterId} AND character_coins.CoinID = {$coinId}";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterCoins query.");
    return $result; 
}

function updateCharacterArmour($cxn, $characterArmourId, $quantity, $magic, $equipmentStatusId)
{
    $query = "UPDATE character_armour SET Quantity = '{$quantity}',ArmourMagic = '{$magic}', EquipmentStatusId = '{$equipmentStatusId}' WHERE character_armour.CharacterArmourId = {$characterArmourId}";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterArmour query.");
    
    return $result;
}

function updateCharacterWeapons($cxn, $characterWeaponId, $quantity, $magic, $equipmentStatusId)
{
    $query = "UPDATE character_weapons SET Quantity = '{$quantity}',WeaponMagic = '{$magic}', EquipmentStatusId = '{$equipmentStatusId}' WHERE character_weapons.CharacterWeaponId = {$characterWeaponId}";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterWeapons query.");
    
    return $result;
}

function getCharacterItems($cxn, $characterId)
{
    $query = "SELECT * FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = $characterId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterItems query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function getCharacterCoins($cxn, $characterId)
{
    $query = "SELECT * FROM character_coins cc INNER JOIN coins c on cc.CoinId = c.CoinId WHERE cc.CharacterId = $characterId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterCoins query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function getCharacterArmour($cxn, $characterId)
{
    $query = "SELECT * FROM character_armour ca INNER JOIN armour a ON ca.ArmourId = a.ArmourId WHERE ca.CharacterId = $characterId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterArmour query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function getCharacterWeapons($cxn, $characterId)
{
    $query = "SELECT * FROM character_weapons cw INNER JOIN weapons w ON cw.WeaponId = w.WeaponId WHERE cw.CharacterId = $characterId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterWeapons query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function osricdb_getCharacterWeaponsByStatus($cxn, $characterId, $equipmentStatus)
{
    $query = sprintf("SELECT * FROM character_weapons cw INNER JOIN weapons w ON cw.WeaponId = w.WeaponId WHERE cw.CharacterId = $characterId AND cw.EquipmentStatusId = '%s'",$equipmentStatus);
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterWeaponsByStatus query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function osricdb_getCharacterWeaponsInStorage($cxn, $characterId)
{
    return osricdb_getCharacterWeaponsByStatus($cxn, $characterId, "1");
}

function osricdb_getCharacterWeaponsCarried($cxn, $characterId)
{
    return osricdb_getCharacterWeaponsByStatus($cxn, $characterId, "2");
}

function osricdb_getCharacterWeaponsInUse($cxn, $characterId)
{
    return osricdb_getCharacterWeaponsByStatus($cxn, $characterId, "3");
}

function osricdb_getCharacterArmourInStorage($cxn, $characterId)
{
    $query = sprintf("SELECT * FROM character_armour ca INNER JOIN armour a ON ca.ArmourId = a.ArmourId WHERE ca.CharacterId = $characterId AND ca.EquipmentStatusId = '%s'","1");
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterArmourInStorage query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function osricdb_getCharacterArmourCarried($cxn, $characterId)
{
    $query = sprintf("SELECT * FROM character_armour ca INNER JOIN armour a ON ca.ArmourId = a.ArmourId WHERE ca.CharacterId = $characterId AND ca.EquipmentStatusId = '%s'","2");
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterArmourCarried query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function osricdb_getCharacterArmourInUse($cxn, $characterId)
{
    $query = sprintf("SELECT * FROM character_armour ca INNER JOIN armour a ON ca.ArmourId = a.ArmourId WHERE ca.CharacterId = $characterId AND ca.EquipmentStatusId = '%s'","3");
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterArmourInUse query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function osricdb_transferCharacterWeapons($cxn, $characterId, $weaponRow)
{
    $transferQuantity = min($weaponRow['transferQuantity'],$weaponRow['quantity']);
    $transferDestination = $weaponRow['transferDestination'];
    $transferSource = $weaponRow['transferSource'];
    
    if($transferDestination == $transferSource)
    {/*Don't transfer weapons if source and destination are the same*/
        return;
    }

    $weaponId = $weaponRow['weaponId'];
    $magic = $weaponRow['weaponMagic'];
    $query = "START TRANSACTION";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query:".$query);    
    
    $query = "SELECT * FROM character_weapons cw WHERE cw.CharacterId = $characterId AND cw.WeaponId = $weaponId AND cw.WeaponMagic = $magic AND cw.EquipmentStatusId = $transferDestination";     
    $result = mysqli_query($cxn,$query) or die("Couldn't execute select character_weapons query: ".$query);
    $row = mysqli_fetch_assoc($result);
	if($row)
	{
			/*row found  Update it's count to be its existing count plus the count just added.*/
			$count = $row['Quantity'] + $transferQuantity;
			if($count > 0)
			{
				$query = "UPDATE character_weapons SET Quantity = $count, WeaponMagic = '{$magic}' WHERE CharacterId = $characterId AND WeaponId = $weaponId AND EquipmentStatusId = $transferDestination";
				$result = mysqli_query($cxn,$query) or die("Couldn't execute update character_weapons query.");
			}
	}
	else
	{
		/*row not found in existing character's weapons inventory.  Insert it as a new row in the character's weapons inventory.*/
		$count = $transferQuantity;
		if($count > 0)
		{
			$query = "INSERT INTO character_weapons (`CharacterId`, `WeaponId`, `Quantity`, `WeaponMagic`, `EquipmentStatusId`) VALUES ('{$characterId}', '{$weaponId}', '{$count}', '{$magic}', '{$transferDestination}')"; 
			$result = mysqli_query($cxn,$query) or die("Couldn't execute insert into character_weapons query: ".$query);	
		}
	}
   
    /*Subtract quantity transferred to destination from the transfer source*/ 
    $characterWeaponId = $weaponRow['characterWeaponId'];
    $updatedSourceQuantity = max(0,$weaponRow['quantity'] - $weaponRow['transferQuantity']);
    echo "updatedSourceQuantity: ".$updatedSourceQuantity;
    
    $query = "UPDATE character_weapons SET Quantity = $updatedSourceQuantity, WeaponMagic = $magic WHERE character_weapons.CharacterWeaponId = $characterWeaponId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterWeapons query: ".$query);
    
    /*End transaction*/
    $query = "COMMIT";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);    
             
}

function osricdb_removeZeroQuantityWeaponRows($cxn)
{
    $query = "DELETE FROM character_weapons WHERE Quantity = 0";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);        
}

function osricdb_removeDiscardedWeaponRows($cxn)
{
    $query = "DELETE FROM character_weapons WHERE EquipmentStatusId = 4";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
}

/*
<summary>Get id portion of a field given a prefix of the field name.
</summary>
*/
function getFieldId($fieldName,$fieldNamePrefix) 
{
    if(strpos($fieldName,$fieldNamePrefix) === 0)
	{
        $fieldNamePrefixLen = strlen($fieldNamePrefix);
		/*extract Id from $field name, e.g. if $field="editedItem3" then Id == 3*/
		$idLen = strlen($fieldName) - $fieldNamePrefixLen;
		$id = substr($fieldName,$fieldNamePrefixLen,$idLen);
        return $id;
    }
    return -1;
}

?>