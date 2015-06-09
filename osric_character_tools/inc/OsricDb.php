<?php
/*
Author: Daniel Lyle
Copyright: May 30,2015
*/
include_once(dirname(__FILE__)."/misc.inc");

class OsricDb
{
  
	protected $cxn;
	
	public function doInit($aHost,$aUser,$aPasswd)
	{
		$aDbname = "osric_db";
		$this->cxn = mysqli_connect($aHost,$aUser,$aPasswd,$aDbname) or die("Couldn't connect to server");
	}
	
	public function getRaceOptions()
	{
		$query = "SELECT * FROM races";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		$options = array();    
		while($row = mysqli_fetch_assoc($result))
		{
			$options[$row['RaceId']] = $row['RaceName'];
		}
		return $options;
	}
	
	public function createCharacter($name="Mr. Generic",$age=42,$gender=1,$weight=140,$height=65,$raceId=0)
	{
		$columnNames = array("CharacterName","CharacterAge","CharacterGender","CharacterWeight","CharacterHeight","RaceId");
		
		/*Create a new character*/
		$query = "INSERT INTO characters ";
		$query = $query . "(";
		$k = 0;
		foreach($columnNames as $columnName)
		{
			if($k == 0)
			{
				$query = $query . $columnName;
			}
			else
			{
				$query = $query . "," . "{$columnName}";
			}
			$k = $k + 1;
		}
		$query = $query . ") VALUES (";
		$query = $query . "'" . $name . "'";
		$query = $query . ",'" . $age . "'";
		$query = $query . ",'" . $gender . "'";
		$query = $query . ",'" . $weight . "'";
		$query = $query . ",'" . $height . "'";
		$query = $query . ",'" . $raceId . "'";
		$query = $query . ")";
		
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.");

		$newCharacterId = mysqli_insert_id($this->cxn);        
		$this->initCharacterCoinsToZero($newCharacterId);
		$this->initCharacterAbilitiesToZero($newCharacterId);
		$this->initCharacterStatusToZero($newCharacterId);    
		return $newCharacterId;
	}
	
	public function initCharacterStatusToZero($characterId)
	{
		$this->editCharacterStatus($characterId,0,0,0,0);
	}

	public function initCharacterAbilitiesToZero($characterId)
	{
		/*Insert a new row in the character_abilities table with abilities zeroed out*/
		$query = "SELECT AbilityId FROM abilities";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute abilities query.");
		$k=0;
		while($row = mysqli_fetch_assoc($result))
		{
			$abilityIds[$k] = $row['AbilityId'];
			$k = $k + 1;
		}
		foreach($abilityIds as $abilityId)
		{
			$query = "INSERT INTO character_abilities (CharacterId,AbilityId,Value) VALUES ('{$characterId}','{$abilityId}','0')";
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
    	}
	}
	
	public function updateCharacterCoins($characterCoinId, $coinQuantity)
	{
		$query = "UPDATE character_coins SET Quantity = '{$coinQuantity}' WHERE character_coins.CharacterCoinId = {$characterCoinId}";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		return $result; 
	}

	public function getCoinIds()
	{
		$query = "SELECT CoinId FROM coins ORDER BY CoinId";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute coins query.");   
		$k=0;    
		while($row = mysqli_fetch_assoc($result))
		{
			$coinIds[$k] = $row['CoinId'];
			$k = $k + 1;            
		}
		return $coinIds;		
	}
	
	public function initCharacterCoinsToZero($characterId)
	{
		$coinIds = $this->getCoinIds();
		
		foreach($coinIds as $coinId)
		{
			$query = sprintf("SELECT * FROM character_coins WHERE CharacterId='%s' AND CoinId='%s'",$characterId,$coinId);
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		   $row = mysqli_fetch_assoc($result);
		   if($row)
			{
				
			}
			else 
			{
				$query = "INSERT INTO character_coins (CharacterId,CoinId,Quantity) VALUES ('{$characterId}','{$coinId}','0')";
				mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);	
			}			
		}    
	}

	/*Edit an existing character*/
	public function editCharacter($characterId,$name,$age,$gender,$weight,$height,$raceId)
	{
		$columnNames = array("CharacterName","CharacterAge","CharacterGender","CharacterWeight","CharacterHeight","RaceId");
		$character = array();
		$character['CharacterName'] = $name;
		$character['CharacterAge'] = $age;
		$character['CharacterGender'] = $gender;
		$character['CharacterWeight'] = $weight;
		$character['CharacterHeight'] = $height;
		$character['RaceId'] = $raceId;
		
		$query = "UPDATE characters ";
		$query = $query . "SET ";
		$k = 0;
		foreach($columnNames as $columnName)
		{
			if($k == 0)
			{
				$query = $query . $columnName;			
			}
			else
			{
				$query = $query . "," . $columnName;	
			}
			$query = $query . "=" . "'" . $character[$columnName] . "'";
			$k = $k + 1;
		}
		
		$query = $query . " WHERE CharacterId = '{$characterId}'";
		
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.");

	}
	
	public function getCharacters()
	{
		$query = "SELECT * from characters";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}

	public function getCharacter($characterId)
	{
		if($characterId == -1)
		{
			$row['CharacterName'] = "Dummy";
			$row['CharacterGender'] = "1";
			$row['CharacterAge'] = "42";
			$row['CharacterHeight'] = "65";
		}
		else
		{
			$query = sprintf("SELECT * FROM characters WHERE CharacterId='%s'",$characterId);
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.");
			$row = mysqli_fetch_assoc($result);
		}
		return $row; 
	}
	
	public function deleteCharacter($characterId)
	{
		if($characterId != -1)
		{
			/*TODO: make this a transaction.  Ideally this should all be one transaction that fails or succeeds as one atomic unit*/
			$query = sprintf("DELETE FROM `character_items` WHERE CharacterId='%s'",$characterId);
			$result = mysqli_query($this->cxn,$query) or die("Error in trying to delete a row in the character_items table.");
			$query = sprintf("DELETE FROM `characters` WHERE CharacterId='%s'",$characterId);
			$result = mysqli_query($this->cxn,$query) or die("Error in trying to delete a row in the characters table.");
			$query = sprintf("DELETE FROM `character_status` WHERE CharacterId='%s'",$characterId);
			$result = mysqli_query($this->cxn,$query) or die("Error in trying to delete a row in the character_status table.");
			$query = sprintf("DELETE FROM `character_abilities` WHERE CharacterId='%s'",$characterId);
			$result = mysqli_query($this->cxn,$query) or die("Error in trying to delete a row in the character_abilities table.");
			$query = sprintf("DELETE FROM `character_coins` WHERE CharacterId='%s'",$characterId);
			$result = mysqli_query($this->cxn,$query) or die("Error in trying to delete rows in the character_coins table.");
			$this->deleteAllClassesForCharacter($characterId);
		}
	}
	
	public function getCharacterClasses($characterId)
	{
		$query = sprintf("SELECT * FROM character_classes cc INNER JOIN classes c ON cc.ClassId = c.ClassId WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($classIds = array();$row = mysqli_fetch_assoc($result);$classIds[]=$row['ClassId']);
		return $classIds;    
	}
	
	public function deleteAllClassesForCharacter($characterId)
	{
		$query = sprintf("DELETE FROM character_classes WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute deleteCharacterClasses query.");
		return $result;
	}
	
	public function addClassesForCharacter($characterId,$selectedCharacterClasses)
	{
		foreach($selectedCharacterClasses as $classId)
		{
			$query = "INSERT INTO character_classes (CharacterId,ClassId) VALUES ('{$characterId}','{$classId}')";
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute addClassesForCharacter query.");
		}
	}
	
	public function editCharacterClasses($characterId,$selectedCharacterClasses)
	{
		$this->deleteAllClassesForCharacter($characterId);
		$this->addClassesForCharacter($characterId,$selectedCharacterClasses);
	}
	
	public function getCharacterAbilities($characterId)
	{
		$query = sprintf("SELECT * FROM character_abilities ca INNER JOIN abilities a on ca.AbilityId = a.AbilityId WHERE ca.CharacterId = '%s'",$characterId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getCharacterStatus($characterId)
	{
		$query = sprintf("SELECT * FROM `character_status` WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query:".$query);
		$row = mysqli_fetch_assoc($result);
		return $row;
	}
	
	public function editCharacterStatus($characterId,$armourClass,$experiencePoints,$fullHitPoints,$remainingHitPoints)
	{
		/*Check whether a row with id==$characterId exists in character_abilities table*/
 		$query = sprintf("SELECT * FROM `character_status` WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);    
		if($row)
		{
			/*Edit an existing row in character_abilities*/
			$query = "UPDATE character_status ";
			$query = $query . "SET ";
			$query = $query . "CharacterStatusArmourClass='".$armourClass."'";			
			$query = $query . ",CharacterStatusExperiencePoints='".$experiencePoints."'";
			$query = $query . ",CharacterStatusFullHitPoints='".$fullHitPoints."'";
			$query = $query . ",CharacterStatusRemainingHitPoints='".$remainingHitPoints."'";
			$query = $query . " WHERE CharacterId = '{$characterId}'";    
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		}
		else 
		{
			$query = "INSERT INTO character_status (CharacterId,CharacterStatusArmourClass,CharacterStatusExperiencePoints,CharacterStatusFullHitPoints,CharacterStatusRemainingHitPoints) VALUE ('{$characterId}','{$armourClass}','{$experiencePoints}','{$fullHitPoints}','{$remainingHitPoints}')";                                           
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		}	
	}
	
	public function getTotalEncumbranceOnPerson($characterId)
	{
    $totalEncumbranceItemsCarried = osricdb_getTotalEncumbranceItemsCarried($this->cxn,$characterId);
    $totalEncumbranceCoinsCarried = osricdb_getTotalEncumbranceCoinsCarried($this->cxn,$characterId);
    $totalEncumbranceWeaponsOnPerson = osricdb_getTotalEncumbranceWeaponsOnPerson($this->cxn,$characterId);
    $totalEncumbranceArmourOnPerson = osricdb_getTotalEncumbranceArmourOnPerson($this->cxn,$characterId);
    $totalEncumbranceOnPerson = $totalEncumbranceItemsCarried + $totalEncumbranceCoinsCarried + $totalEncumbranceWeaponsOnPerson + $totalEncumbranceArmourOnPerson;
    return $totalEncumbranceOnPerson;
	}
	
	public function getEquipmentStatusOptions()
	{
		$query = "SELECT * FROM equipment_status";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute getEquipmentStatusOptions query.");
		$options = array();
		while($row = mysqli_fetch_assoc($result))
		{
			$options[$row['EquipmentStatusId']] = $row['EquipmentStatus'];
		}
		return $options;
	}
	
	public function getItemStatusOptions()
	{
		$query = "SELECT * FROM item_status";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute getItemStatusOptions query.");
		$options = array();
		while($row = mysqli_fetch_assoc($result))
		{
			$options[$row['ItemStatusId']] = $row['ItemStatus'];
		}
		return $options;
	}
	
	public function getClasses()
	{
		$query = "SELECT * FROM classes";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getCharacterCoinsInStorage($characterId)
	{
		return $this->getCharacterCoinsByStatus($characterId,"1");
	}
	
	public function getCharacterCoinsCarried($characterId)
	{
		return $this->getCharacterCoinsByStatus($characterId,"2");
	}
	
	public function getCharacterCoins($characterId)
	{
		$query = "SELECT cc.CharacterId,cc.CoinId,cc.Quantity FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = $characterId ORDER BY cc.CoinId";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	private function getCharacterCoinsByStatus($characterId,$itemStatusId)
	{
		$query = sprintf("SELECT * FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = $characterId AND cc.ItemStatusId = '%s'",$itemStatusId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getCharacterWeaponsInStorage($characterId)
	{
		return $this->getCharacterWeaponsByStatus($characterId, "1");
	}

	public function getCharacterWeaponsCarried($characterId)
	{
		return $this->getCharacterWeaponsByStatus($characterId, "2");
	}

	public function getCharacterWeaponsInUse($characterId)
	{
		return $this->getCharacterWeaponsByStatus($characterId, "3");
	}

	private function getCharacterWeaponsByStatus($characterId, $equipmentStatus)
	{
		$query = sprintf("SELECT * FROM character_weapons cw INNER JOIN weapons w ON cw.WeaponId = w.WeaponId WHERE cw.CharacterId = $characterId AND cw.EquipmentStatusId = '%s'",$equipmentStatus);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute getCharacterWeaponsByStatus query.");
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}

	public function getCharacterBaseArmourClass($characterId)	
	{
		$characterStatus = $this->getCharacterStatus($characterId);
		return $characterStatus['CharacterStatusArmourClass'];		
	}
	
	public function getCharacterArmourEffectOnAC($characterId)
	{
		$combinedEffectOnAC = 0;		
		$armourInUse = $this->getCharacterArmourInUse($characterId);
		foreach($armourInUse as $row)
		{
			$combinedEffectOnAC += ($row['ArmourEffectOnArmourClass'] * $row['Quantity']);
		}
		return $combinedEffectOnAC;
	}
	
	public function getCharacterEffectiveArmourClass($characterId)
	{
		$baseArmourClass = $this->getCharacterBaseArmourClass($characterId);
		$combinedEffectOnAC = $this->getCharacterArmourEffectOnAC($characterId);
		return $baseArmourClass + $combinedEffectOnAC;	
	}

	public function getCharacterArmourInStorage($characterId)
	{
		return $this->getCharacterArmourByStatus($characterId, "1");	
	}

	public function getCharacterArmourCarried($characterId)
	{
		return $this->getCharacterArmourByStatus($characterId, "2");
	}

	public function getCharacterArmourInUse($characterId)
	{
		return $this->getCharacterArmourByStatus($characterId, "3");
	}
	
	private function getCharacterArmourByStatus($characterId, $equipmentStatus)
	{
		$query = sprintf("SELECT * FROM character_armour ca INNER JOIN armour a ON ca.ArmourId = a.ArmourId WHERE ca.CharacterId = $characterId AND ca.EquipmentStatusId = '%s'",$equipmentStatus);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute getCharacterArmourInStorage query.");
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getCharacterItemsCarried($characterId)
	{
		return $this->getCharacterItemsByStatus($characterId,"2");
	}

	public function getCharacterItemsInStorage($characterId)
	{
		return $this->getCharacterItemsByStatus($characterId,"1");
	}

	private function getCharacterItemsByStatus($characterId,$itemStatusId)
	{
		$query = sprintf("SELECT * FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = $characterId AND ci.ItemStatusId = '%s'",$itemStatusId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getArmour()
	{
		$query = "SELECT * FROM armour";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;	
	}
	
	public function getItems()
	{
		$query = "SELECT * FROM items";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getWeapons()
	{
		$query = "SELECT * FROM weapons";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function addToCharacterArmour($characterId, $armourId, $quantityToAdd)
	{
		if($armourId != -1)
		{
			/*Check if armour is already in character's inventory.  If it is
			then get the count of that item in the character's inventory and
			update it to be the sum of the value submitted to the existing
			number.  If it isn't yet in the character's inventory then
			insert it as a new row in the character's inventory.*/ 
			$query = "SELECT * FROM character_armour ca WHERE ca.CharacterId = '{$characterId}' AND ca.ArmourId = '{$armourId}'";
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
			$row = mysqli_fetch_assoc($result);
			if($row)
			{
				/*item found in existing inventory.  Update it's count to be its existing count plus the count just added.*/
				$count = $row['Quantity'] + $quantityToAdd;
				if($count > 0)
				{
					$query = "UPDATE character_armour SET Quantity = '{$count}' WHERE CharacterId = '{$characterId}' AND ArmourId = '{$armourId}'";
					$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
				}
			}
			else
			{
				/*item not found in existing inventory.  Insert it as a new row in the character's inventory.*/
				$count = $quantityToAdd;
				if($count > 0)
				{
					$query = "INSERT INTO character_armour (`CharacterId`, `ArmourId`, `Quantity`) VALUES ('{$characterId}', '{$armourId}', '{$count}')"; 
					$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query:".$query);	
				}
			}
		}
	}
	
	public function addToCharacterWeapons($characterId, $weaponId, $quantityToAdd)    
	{    
    	if($weaponId != -1)
    	{
			/*Check if weapon is already in character's inventory.  If it is
			then get the count of that weapon in the character's inventory and
			update it to be the sum of the value submitted to the existing
			number.  If it isn't yet in the character's inventory then
			insert it as a new row in the character's inventory.*/ 
			$query = "SELECT * FROM character_weapons cw WHERE cw.CharacterId = '{$characterId}' AND cw.WeaponId = '{$weaponId}'";
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: " . $query);
			$row = mysqli_fetch_assoc($result);
			if($row)
			{
				/*weapon found in existing inventory.  Update it's count to be its existing count plus the count just added.*/
				$count = $row['Quantity'] + $quantityToAdd;
				if($count > 0)
				{
					$query = "UPDATE character_weapons SET Quantity = '{$count}' WHERE CharacterId = '{$characterId}' AND WeaponId = '{$weaponId}'";
					$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: " . $query);
				}
			}
			else
			{
				/*weapon not found in existing inventory.  Insert it as a new row in the character's inventory.*/
				$count = $quantityToAdd;
				if($count > 0)
				{
					$query = "INSERT INTO character_weapons (`CharacterId`, `WeaponId`, `Quantity`) VALUES ('{$characterId}', '{$weaponId}', '{$count}')"; 
					$result = mysqli_query($this->cxn,$query) or die("Couldn't execute insert into character_weapons query.");	
				}
			}
		}
	}
	
	function addToCharacterItems($characterId,$itemId,$quantityToAdd)
	{
		if($itemId != -1)
		{
		/*Check if item is already in character's inventory.  If it is
			then get the count of that item in the character's inventory and
			update it to be the sum of the value submitted to the existing
			number.  If it isn't yet in the character's inventory then
			insert it as a new row in the character's inventory.*/ 
			$query = "SELECT * FROM character_items ci WHERE ci.CharacterId = '{$characterId}' AND ci.ItemId = '{$itemId}'";
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.");
			$row = mysqli_fetch_assoc($result);
			if($row)
			{
				/*item found in existing inventory.  Update it's count to be its existing count plus the count just added.*/
				$count = $row['Quantity'] + $quantityToAdd;
				if($count > 0)
				{
					$query = "UPDATE character_items SET Quantity = '{$count}' WHERE CharacterId = '{$characterId}' AND ItemId = '{$itemId}'";
					$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.");
				}
			}
			else
			{
				/*item not found in existing inventory.  Insert it as a new row in the character's inventory.*/
				$count = $quantityToAdd;
				if($count > 0)
				{
					$query = "INSERT INTO character_items (`CharacterId`, `ItemId`, `Quantity`) VALUES ('{$characterId}', '{$itemId}', '{$count}')"; 
					$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.");	
				}
			}
		}
	}
	
	public function getWeaponAsMelee($weaponId)
	{
		$query = "SELECT * FROM weapon_as_melee WHERE WeaponId = $weaponId";
		$result = mysqli_query($this->cxn, $query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);
		return $row;   
	}

	public function getWeaponAsMissile($weaponId)
	{
		$query = "SELECT * FROM weapon_as_missile WHERE WeaponId = $weaponId";
		$result = mysqli_query($this->cxn, $query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);
		return $row;
	}
}

?>