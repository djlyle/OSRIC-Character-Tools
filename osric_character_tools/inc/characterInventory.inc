<?php
include("./osricdb_constants.inc");

function osricdb_getTotalItemEncumbrance($cxn, $characterId)
{
	$query = "SELECT SUM(e.TotalItemEncumbrance) AS TotalEncumbrance FROM (SELECT (i.ItemEncumbrance * ci.Quantity) AS TotalItemEncumbrance FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = '{$characterId}') AS e";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute getTotalEncumbrance query.");
	$row = mysqli_fetch_assoc($result);
	return $row['TotalEncumbrance'];
}

function osricdb_getTotalCoinEncumbrance($cxn, $characterId)
{
    $query = "SELECT SUM(e.TotalCoinEncumbrance) AS TotalEncumbrance FROM (SELECT (c.CoinEncumbranceInLbs * cc.Quantity) AS TotalCoinEncumbrance FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = '{$characterId}') AS e"; 
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getTotalCoinEncumbrance.");
    $row = mysqli_fetch_assoc($result);
    return $row['TotalEncumbrance'];
}

function osricdb_getTotalEncumbranceCoinsCarried($cxn, $characterId)
{
    $query = "SELECT SUM(e.TotalCoinEncumbrance) AS TotalEncumbrance FROM (SELECT (c.CoinEncumbranceInLbs * cc.Quantity) AS TotalCoinEncumbrance FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = '{$characterId}' AND cc.ItemStatusId = '2') AS e"; 
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    $row = mysqli_fetch_assoc($result);
    return $row['TotalEncumbrance'];
}

function osricdb_getTotalEncumbranceItemsCarried($cxn, $characterId)
{
	$query = "SELECT SUM(e.TotalItemEncumbrance) AS TotalEncumbrance FROM (SELECT (i.ItemEncumbrance * ci.Quantity) AS TotalItemEncumbrance FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = '{$characterId}' AND ci.ItemStatusId = '2') AS e";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
	$row = mysqli_fetch_assoc($result);
	return $row['TotalEncumbrance'];
}

function osricdb_getTotalEncumbranceWeaponsOnPerson($cxn, $characterId)
{
    $query = "SELECT SUM(e.TotalWeaponEncumbrance) AS TotalEncumbrance FROM (SELECT (w.WeaponEncumbranceInLbs * cw.Quantity) AS TotalWeaponEncumbrance FROM character_weapons cw INNER JOIN weapons w ON cw.WeaponId = w.WeaponId WHERE cw.CharacterId = '{$characterId}' AND (cw.EquipmentStatusId = '2' OR cw.EquipmentStatusId = '3')) AS e";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
	$row = mysqli_fetch_assoc($result);
	return $row['TotalEncumbrance'];
}

function osricdb_getTotalEncumbranceArmourOnPerson($cxn, $characterId)
{
    $query = "SELECT SUM(e.TotalArmourEncumbrance) AS TotalEncumbrance FROM (SELECT (a.ArmourEncumbrance * ca.Quantity) AS TotalArmourEncumbrance FROM character_armour ca INNER JOIN armour a ON ca.ArmourId = a.ArmourId WHERE ca.CharacterId = '{$characterId}' AND (ca.EquipmentStatusId = '2' OR ca.EquipmentStatusId = '3')) AS e";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
	$row = mysqli_fetch_assoc($result);
	return $row['TotalEncumbrance'];
}

function osricdb_getTotalEncumbranceOnPerson($cxn, $characterId)
{
    $totalEncumbranceItemsCarried = osricdb_getTotalEncumbranceItemsCarried($cxn,$characterId);
    $totalEncumbranceCoinsCarried = osricdb_getTotalEncumbranceCoinsCarried($cxn,$characterId);
    $totalEncumbranceWeaponsOnPerson = osricdb_getTotalEncumbranceWeaponsOnPerson($cxn,$characterId);
    $totalEncumbranceArmourOnPerson = osricdb_getTotalEncumbranceArmourOnPerson($cxn,$characterId);
    $totalEncumbranceOnPerson = $totalEncumbranceItemsCarried + $totalEncumbranceCoinsCarried + $totalEncumbranceWeaponsOnPerson + $totalEncumbranceArmourOnPerson;
    return $totalEncumbranceOnPerson;
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

function osricdb_updateCharacterCoins($cxn, $characterCoinId, $coinQuantity)
{
    $query = "UPDATE character_coins SET Quantity = '{$coinQuantity}' WHERE character_coins.CharacterCoinId = {$characterCoinId}";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
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

function osricdb_getCharacterCoinsInStorage($cxn,$characterId)
{
    return osricdb_getCharacterCoinsByStatus($cxn,$characterId,"1");
}

function osricdb_getCharacterCoinsCarried($cxn,$characterId)
{
    return osricdb_getCharacterCoinsByStatus($cxn,$characterId,"2");
}

function osricdb_getCharacterItemsCarried($cxn,$characterId)
{
    return osricdb_getCharacterItemsByStatus($cxn,$characterId,"2");
}

function osricdb_getCharacterItemsInStorage($cxn,$characterId)
{
    return osricdb_getCharacterItemsByStatus($cxn,$characterId,"1");
}

function osricdb_getCharacterItemsByStatus($cxn,$characterId,$itemStatusId)
{
    $query = sprintf("SELECT * FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = $characterId AND ci.ItemStatusId = '%s'",$itemStatusId);
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}


function osricdb_getCharacterCoinsByStatus($cxn,$characterId,$itemStatusId)
{
    $query = sprintf("SELECT * FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = $characterId AND cc.ItemStatusId = '%s'",$itemStatusId);
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function osricdb_transferCharacterArmour($cxn, $characterId, $armourRow)
{
    $transferQuantity = min($armourRow['transferQuantity'],$armourRow['quantity']);
    $transferDestination = $armourRow['transferDestination'];
    $transferSource = $armourRow['transferSource'];
    
    if($transferDestination == $transferSource)
    {/*Don't transfer weapons if source and destination are the same*/
        return;
    }

    $armourId = $armourRow['armourId'];
    $magic = $armourRow['armourMagic'];
    $query = "START TRANSACTION";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query:".$query);    
    
    $query = "SELECT * FROM character_armour WHERE CharacterId = $characterId AND ArmourId = $armourId AND ArmourMagic = $magic AND EquipmentStatusId = $transferDestination";     
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    $row = mysqli_fetch_assoc($result);
	if($row)
	{
			/*row found  Update it's count to be its existing count plus the count just added.*/
			$count = $row['Quantity'] + $transferQuantity;
			if($count > 0)
			{
				$query = "UPDATE character_armour SET Quantity = $count, ArmourMagic = $magic WHERE CharacterId = $characterId AND ArmourId = $armourId AND ArmourMagic = $magic AND EquipmentStatusId = $transferDestination";
				$result = mysqli_query($cxn,$query) or die("Couldn't execute update character_weapons query.");
			}
	}
	else
	{
		/*row not found in existing character's armour inventory.  Insert it as a new row in the character's armour inventory.*/
		$count = $transferQuantity;
		if($count > 0)
		{
			$query = "INSERT INTO character_armour (`CharacterId`, `ArmourId`, `Quantity`, `ArmourMagic`, `EquipmentStatusId`) VALUES ('{$characterId}', '{$armourId}', '{$count}', '{$magic}', '{$transferDestination}')"; 
			$result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);	
		}
	}
   
    /*Subtract quantity transferred to destination from the transfer source*/ 
    $characterArmourId = $armourRow['characterArmourId'];
    $updatedSourceQuantity = max(0,$armourRow['quantity'] - $armourRow['transferQuantity']);
    /*echo "updatedSourceQuantity: ".$updatedSourceQuantity;*/
    
    $query = "UPDATE character_armour SET Quantity = $updatedSourceQuantity, ArmourMagic = $magic WHERE CharacterArmourId = $characterArmourId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    
    /*End transaction*/
    $query = "COMMIT";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
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
    /*echo "updatedSourceQuantity: ".$updatedSourceQuantity;*/
    
    $query = "UPDATE character_weapons SET Quantity = $updatedSourceQuantity, WeaponMagic = $magic WHERE character_weapons.CharacterWeaponId = $characterWeaponId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterWeapons query: ".$query);
    
    /*End transaction*/
    $query = "COMMIT";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);    
             
}

function osricdb_transferCharacterCoins($cxn, $characterId, $coinRow)
{
    $transferQuantity = min($coinRow['transferQuantity'],$coinRow['quantity']);
    $transferDestination = $coinRow['transferDestination'];
    $transferSource = $coinRow['transferSource'];
    
    if($transferDestination == $transferSource)
    {/*Don't transfer coins if source and destination are the same*/
        return;
    }

    $coinId = $coinRow['coinId'];
    $query = "START TRANSACTION";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query:".$query);    
    
    $query = "SELECT * FROM character_coins WHERE CharacterId = $characterId AND CoinId = $coinId AND ItemStatusId = $transferDestination";     
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    $row = mysqli_fetch_assoc($result);
	if($row)
	{
    		/*row found  Update it's count to be its existing count plus the count just added.*/
			$count = $row['Quantity'] + $transferQuantity;
            /*echo "count: ".$count;*/
			if($count > 0)
			{
				$query = "UPDATE character_coins SET Quantity = $count WHERE CharacterId = $characterId AND CoinId = $coinId AND ItemStatusId = $transferDestination";
                $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
			}
	}
	else
	{
    	/*row not found in existing character's coins inventory.  Insert it as a new row in the character's coins inventory.*/
		$count = $transferQuantity;
		if($count > 0)
		{
			$query = "INSERT INTO character_coins (`CharacterId`, `CoinId`, `Quantity`, `ItemStatusId`) VALUES ('{$characterId}', '{$coinId}', '{$count}', '{$transferDestination}')"; 
			$result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);	
		}
	}
   
    /*Subtract quantity transferred to destination from the transfer source*/ 
    $characterCoinId = $coinRow['characterCoinId'];
    $updatedSourceQuantity = max(0,$coinRow['quantity'] - $coinRow['transferQuantity']);
    
    $query = "UPDATE character_coins SET Quantity = $updatedSourceQuantity WHERE CharacterCoinId = $characterCoinId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    
    /*End transaction*/
    $query = "COMMIT";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
}

function osricdb_transferCharacterItems($cxn, $characterId, $itemRow)
{
    $transferQuantity = min($itemRow['transferQuantity'],$itemRow['quantity']);
    $transferDestination = $itemRow['transferDestination'];
    $transferSource = $itemRow['transferSource'];
    
    if($transferDestination == $transferSource)
    {/*Don't transfer coins if source and destination are the same*/
        return;
    }

    $itemId = $itemRow['itemId'];
    $query = "START TRANSACTION";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query:".$query);    
    
    $query = "SELECT * FROM character_items WHERE CharacterId = $characterId AND ItemId = $itemId AND ItemStatusId = $transferDestination";     
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    $row = mysqli_fetch_assoc($result);
	if($row)
	{
            /*row found  Update it's count to be its existing count plus the count just added.*/
			$count = $row['Quantity'] + $transferQuantity;
            if($count > 0)
			{
				$query = "UPDATE character_items SET Quantity = $count WHERE CharacterId = $characterId AND ItemId = $itemId AND ItemStatusId = $transferDestination";
                $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
			}
	}
	else
	{
        /*row not found in existing character's items inventory.  Insert it as a new row in the character's items inventory.*/
		$count = $transferQuantity;
		if($count > 0)
		{
			$query = "INSERT INTO character_items (`CharacterId`, `ItemId`, `Quantity`, `ItemStatusId`) VALUES ('{$characterId}', '{$itemId}', '{$count}', '{$transferDestination}')"; 
			$result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);	
		}
	}
   
    /*Subtract quantity transferred to destination from the transfer source*/ 
    $characterItemId = $itemRow['characterItemId'];
    $updatedSourceQuantity = max(0,$itemRow['quantity'] - $itemRow['transferQuantity']);
    
    $query = "UPDATE character_items SET Quantity = $updatedSourceQuantity WHERE CharacterItemId = $characterItemId";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
    
    /*End transaction*/
    $query = "COMMIT";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
}

function osricdb_removeZeroQuantityItemRows($cxn)
{
    $query = "DELETE FROM character_items WHERE Quantity = 0";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);        
}

function osricdb_removeDiscardedItemRows($cxn)
{
    $query = "DELETE FROM character_items WHERE ItemStatusId = 3";
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

function osricdb_removeZeroQuantityArmourRows($cxn)
{
    $query = "DELETE FROM character_armour WHERE Quantity = 0";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);        
}

function osricdb_removeDiscardedArmourRows($cxn)
{
    $query = "DELETE FROM character_armour WHERE EquipmentStatusId = 4";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
}

function osricdb_removeZeroQuantityCoinRows($cxn)
{
    $query = "DELETE FROM character_coins WHERE Quantity = 0";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
}

function osricdb_removeDiscardedCoinRows($cxn)
{
    $query = "DELETE FROM character_coins WHERE ItemStatusId = 3";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute query: ".$query);
}

function osricdb_getWeaponAsMelee($cxn, $weaponId)
{
    $query = "SELECT * FROM weapon_as_melee WHERE WeaponId = $weaponId";
    $result = mysqli_query($cxn, $query) or die("Couldn't execute query: ".$query);
    $row = mysqli_fetch_assoc($result);
    return $row;   
}

function osricdb_getWeaponAsMissile($cxn, $weaponId)
{
    $query = "SELECT * FROM weapon_as_missile WHERE WeaponId = $weaponId";
    $result = mysqli_query($cxn, $query) or die("Couldn't execute query: ".$query);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function osric_getWeaponDmgVsSmallToMedium($weapon)
{
    if($weapon == null) return "N\A";
        
    $modifier = $weapon['DamageModifierVsSmallOrMedium'];
    $modifierStr = "";    
    if($modifier > 0)
    {
        $modifierStr = "+".$modifier;
    }
    return "".$weapon['DamageVsSmallOrMediumMultiples']."d".$weapon['DamageVsSmallOrMedium'].$modifierStr;
}

function osric_getWeaponDmgVsLarge($weapon)
{
    if($weapon == null) return "N\A";
    $modifier = $weapon['DamageModifierVsLarge'];
    $modifierStr = "";    
    if($modifier > 0)
    {
        $modifierStr = "+".$modifier;
    }
    return "".$weapon['DamageVsLargeMultiples']."d".$weapon['DamageVsLarge'].$modifierStr;
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