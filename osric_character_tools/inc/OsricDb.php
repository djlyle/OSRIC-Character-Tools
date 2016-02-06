<?php
/*
File: OsricDb.php
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
	
	public function updateCharacterAbility($characterId, $abilityId, $value)
	{
		$query = "UPDATE character_abilities SET Value = '{$value}' WHERE character_abilities.CharacterId = {$characterId} AND character_abilities.AbilityId = {$abilityId}";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		return $result; 
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
	
	public function getCoinNamesAndIds()
	{
		$query = "SELECT CoinName,CoinId FROM coins ORDER BY CoinId";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);   
		$coinNameIds = array();    
		while($row = mysqli_fetch_assoc($result))
		{
			$coinNameIds[$row['CoinName']] = $row['CoinId'];
		}
		return $coinNameIds;		
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
	
	private function getCharacterClassesResultSet($characterId)
	{
		$query = sprintf("SELECT * FROM character_classes cc INNER JOIN classes c ON cc.ClassId = c.ClassId WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		return $result;
	}
	
	public function getCharacterClasses($characterId)
	{
		$result = $this->getCharacterClassesResultSet($characterId);
		for($classIds = array();$row = mysqli_fetch_assoc($result);$classIds[]=$row['ClassId']);
		return $classIds;    
	}
	
	public function getCharacterClassesAsNames($characterId)
	{
		$result = $this->getCharacterClassesResultSet($characterId);
		for($classNames = array();$row = mysqli_fetch_assoc($result);$classNames[]=$row['ClassName']);
		return $classNames;
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
	
	public function getTotalEncumbranceItemsCarried($characterId)
	{
		$query = "SELECT SUM(e.TotalItemEncumbrance) AS TotalEncumbrance FROM (SELECT (i.ItemEncumbrance * ci.Quantity) AS TotalItemEncumbrance FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = '{$characterId}') AS e";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);
		return $row['TotalEncumbrance'];
	}	

	public function getTotalEncumbranceCoinsCarried($characterId)	
	{
		$query = "SELECT SUM(e.TotalCoinEncumbrance) AS TotalEncumbrance FROM (SELECT (c.CoinEncumbranceInLbs * cc.Quantity) AS TotalCoinEncumbrance FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = '{$characterId}') AS e"; 
    	$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
    	$row = mysqli_fetch_assoc($result);
    	return $row['TotalEncumbrance'];
	}
	
	public function getTotalEncumbranceOnPerson($characterId)
	{
		$totalEncumbranceItemsCarried = $this->getTotalEncumbranceItemsCarried($characterId);
		$totalEncumbranceCoinsCarried = $this->getTotalEncumbranceCoinsCarried($characterId);
		$totalEncumbranceOnPerson = $totalEncumbranceItemsCarried + $totalEncumbranceCoinsCarried;
		return $totalEncumbranceOnPerson;
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

	public function getCharacterGoldCoinsInStorage($characterId)
	{
		return $this->getCharacterCoinsInStorageByCoinId($characterId,"1");
	}
	
	public function getCharacterSilverCoinsInStorage($characterId)
	{
		return $this->getCharacterCoinsInStorageByCoinId($characterId,"2");	
	}	

	public function getCharacterCopperCoinsInStorage($characterId)
	{
		return $this->getCharacterCoinsInStorageByCoinId($characterId,"3");	
	}
	
	public function getCharacterPlatinumCoinsInStorage($characterId)
	{
		return $this->getCharacterCoinsInStorageByCoinId($characterId,"4");	
	}
	
	public function getCharacterElectrumCoinsInStorage($characterId)
	{
		return $this->getCharacterCoinsInStorageByCoinId($characterId,"5");	
	}
	
	private function getCharacterCoinsInStorageByCoinId($characterId,$coinId)
	{
		$character_coins_in_storage = $this->getCharacterCoinsInStorage($characterId);
		foreach($character_coins_in_storage as $row)
		{
			if($row['CoinId'] == $coinId)
			{
				return $row['Quantity'];
			}
		}
	}
	
	public function getCharacterCoinsInStorage($characterId)
	{
		return $this->getCharacterCoinsByStatus($characterId,"1");
	}
	
	public function getCharacterCoinsCarried($characterId)
	{
		return $this->getCharacterCoinsByStatus($characterId,"2");
	}
	
	public function getCharacterCoinsInUse($characterId)
	{
		return $this->getCharacterCoinsByStatus($characterId,"3");
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
		$query = "SELECT * FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = $characterId AND cc.ItemStatusId = $itemStatusId";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query:".$query);
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

	private function getCharacterWeaponsByStatus($characterId, $itemStatus)
	{
		return $this->getCharacterItemTypeByStatus($characterId, "2", $itemStatus);
	}
	
	private function getCharacterItemTypeByStatus($characterId, $itemType, $itemStatus)
	{
		$query = "SELECT i.ItemName,i.ItemEncumbrance,i.ItemCost,ci.Quantity,ci.Magic,ci.CharacterItemId,i.ItemId FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = $characterId AND i.ItemType = $itemType AND ci.ItemStatusId = $itemStatus";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
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
	
	private function getCharacterArmourByStatus($characterId, $itemStatus)
	{
		$query = "SELECT i.ItemName,a.ArmourEffectOnArmourClass,i.ItemEncumbrance,a.ArmourMovementRate,i.ItemCost,ci.Quantity,ci.Magic,ci.ItemStatusId,ci.CharacterItemId,i.ItemId FROM character_items ci INNER JOIN armour a ON ci.ItemId = a.ItemId INNER JOIN items i ON i.ItemId = a.ItemId WHERE ci.CharacterId = $characterId AND ci.ItemStatusId = $itemStatus";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query:".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getCharacterItemsInUse($characterId)
	{
		return $this->getCharacterItemsByStatus($characterId,"3");
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
		$query = "SELECT * FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = $characterId AND i.ItemType = '0' AND ci.ItemStatusId = $itemStatusId";
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
	
	public function getItemsByItemType($itemType)
	{
		$query = sprintf("SELECT * FROM items WHERE ItemType = '%s'",$itemType);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getItemCost($itemId)
	{
		$query = "SELECT * FROM items WHERE ItemId = '{$itemId}'";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);
		return $row['ItemCost'];		
	}
	
	public function getWeapons()
	{
		$query = "SELECT * FROM weapons";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
		return $result_set;
	}
	
	public function getWeapon($itemId)
	{
		$query = "SELECT * FROM weapons WHERE ItemId = $itemId";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);
		return $row;
	}

	public function addToCharacterItems($characterId,$itemId,$quantityToAdd)
	{
		if($itemId != -1)
		{
		/*Check if item is already in character's in storage inventory).  If it is
			then get the count of that item in the character's in storage inventory and
			update it to be the sum of the value submitted to the existing
			number.  If it isn't yet in the character's inventory then
			insert it as a new row in the character's inventory.*/ 
			$query = "SELECT * FROM character_items ci WHERE ci.CharacterId = '{$characterId}' AND ci.ItemId = '{$itemId}' AND ci.ItemStatusId='1'";
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.".$query);
			$row = mysqli_fetch_assoc($result);
			if($row)
			{
				/*item found in existing inventory.  Update it's count to be its existing count plus the count just added.*/
				$count = $row['Quantity'] + $quantityToAdd;
				if($count > 0)
				{
					$query = "UPDATE character_items SET Quantity = '{$count}' WHERE CharacterId = '{$characterId}' AND ItemId = '{$itemId}' AND ItemStatusId='1'";
					$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.".$query);
				}
			}
			else
			{
				/*item not found in existing inventory.  Insert it as a new row in the character's inventory.*/
				$count = $quantityToAdd;
				if($count > 0)
				{
					$query = "INSERT INTO character_items (`CharacterId`, `ItemId`, `Quantity`,`ItemStatusId`) VALUES ('{$characterId}', '{$itemId}', '{$count}','1')"; 
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
	
	public function 	addToCharacterXP($characterId,$xpToAdd)
	{
		$query = "SELECT * FROM character_status WHERE CharacterId = $characterId";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);
		if($row)
		{
			/*Row found. Update its count to be its existing count plus the count just added*/
			$count = max(0,$row['CharacterStatusExperiencePoints'] + $xpToAdd);
			$query = "UPDATE character_status SET CharacterStatusExperiencePoints = $count WHERE CharacterId = $characterId";
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		}
	}
	
	public function getCharacterXP($characterId){
		$query = "SELECT * FROM character_status WHERE CharacterId = $characterId";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);
		if($row)
		{
			return $row['CharacterStatusExperiencePoints'];
		}
		else 
		{
			return -1;
		}
	}
	
	public function addToCharacterCoins($characterId,$coinId,$quantityToAdd,$destination)
	{
		$query = "SELECT * FROM character_coins WHERE CharacterId = $characterId AND CoinId = $coinId AND ItemStatusId = $destination";     
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		$row = mysqli_fetch_assoc($result);
		if($row)
		{
			/*row found  Update it's count to be its existing count plus the count just added.*/
			$count = max(0,$row['Quantity'] + $quantityToAdd);
			$query = "UPDATE character_coins SET Quantity = $count WHERE CharacterId = $characterId AND CoinId = $coinId AND ItemStatusId = $destination";
			$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
		}
		else
		{
    		/*row not found in existing character's coins inventory.  Insert it as a new row in the character's coins inventory.*/
			$count = $quantityToAdd;
			if($count > 0)
			{
				$query = "INSERT INTO character_coins (`CharacterId`, `CoinId`, `Quantity`, `ItemStatusId`) VALUES ('{$characterId}', '{$coinId}', '{$count}', '{$destination}')"; 
				$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);	
			}
		}
	}
	
	public function transferCharacterCoinsFromSourceToDest($characterId, $coinId, $transferQuantity, $transferSource, $transferDestination)
	{
		$query = "START TRANSACTION";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query:".$query);    

		$this->addToCharacterCoins($characterId,$coinId,$transferQuantity,$transferDestination);	 	
   
		/*Subtract quantity transferred to destination from the transfer source*/ 
		$this->addToCharacterCoins($characterId,$coinId,-1*$transferQuantity,$transferSource);
		    
		/*End transaction*/
		$query = "COMMIT";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
	}
	
	public function transferCharacterCoins($characterId, $coinRow)
	{
		$transferQuantity = min($coinRow['transferQuantity'],$coinRow['quantity']);
		$transferDestination = $coinRow['transferDestination'];
		$transferSource = $coinRow['transferSource'];
    
		if($transferDestination == $transferSource)
		{/*Don't transfer coins if source and destination are the same*/
			return;
		}

		$coinId = $coinRow['coinId'];
		$this->transferCharacterCoinsFromSourceToDest($characterId,$coinId,$transferQuantity,$transferSource,$transferDestination);
	}
	
	public function transferCharacterItems($characterId, $itemRow)
	{
    	$transferQuantity = min($itemRow['transferQuantity'],$itemRow['quantity']);
    	$transferDestination = $itemRow['transferDestination'];
    	$transferSource = $itemRow['transferSource'];
      if($transferDestination == $transferSource)
    	{/*Don't transfer item if source and destination are the same*/
      	  return;
    	}
    	
    	$itemId = $itemRow['itemId'];
    	$query = "START TRANSACTION";
    	$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query:".$query);    
    
    	$query = "SELECT * FROM character_items WHERE CharacterId = $characterId AND ItemId = $itemId AND ItemStatusId = $transferDestination";     
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
    	$row = mysqli_fetch_assoc($result);
		if($row)
		{
            /*row found  Update it's count to be its existing count plus the count just added.*/
			$count = $row['Quantity'] + $transferQuantity;
         if($count > 0)
			{
				$query = "UPDATE character_items SET Quantity = $count WHERE CharacterId = $characterId AND ItemId = $itemId AND ItemStatusId = $transferDestination";
            $result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
			}
		}
		else
		{
        /*row not found in existing character's items inventory.  Insert it as a new row in the character's items inventory.*/
			$count = $transferQuantity;
			if($count > 0)
			{
				$query = "INSERT INTO character_items (`CharacterId`, `ItemId`, `Quantity`, `ItemStatusId`) VALUES ('{$characterId}', '{$itemId}', '{$count}', '{$transferDestination}')"; 
				$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);	
			}
		}
   
    	/*Subtract quantity transferred to destination from the transfer source*/ 
    	$characterItemId = $itemRow['characterItemId'];
    	$updatedSourceQuantity = max(0,$itemRow['quantity'] - $itemRow['transferQuantity']);
    
    	$query = "UPDATE character_items SET Quantity = $updatedSourceQuantity WHERE CharacterItemId = $characterItemId";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
    
    	/*End transaction*/
    	$query = "COMMIT";
    	$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
	}
	
	public function removeZeroQuantityItemRows()
	{
		$query = "DELETE FROM character_items WHERE Quantity = 0";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);        
	}

	public function removeDiscardedItemRows()
	{
		$query = "DELETE FROM character_items WHERE ItemStatusId = 4";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
	}
	
	public function removeZeroQuantityCoinRows()
	{
   	$query = "DELETE FROM character_coins WHERE Quantity = 0";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
	}
	
	public function removeDiscardedCoinRows()
	{
		$query = "DELETE FROM character_coins WHERE ItemStatusId = 4";
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query: ".$query);
	}
	
	public function subtractDebitFromCharacterCoins($characterId,$debitInGold)
	{
		$debit_cc = bcmul($debitInGold, "100", 2);
		
		$orig_purse_pc = $this->getCharacterPlatinumCoinsInStorage($characterId);		
		$orig_purse_gc = $this->getCharacterGoldCoinsInStorage($characterId);
		$orig_purse_ec = $this->getCharacterElectrumCoinsInStorage($characterId);
		$orig_purse_sc = $this->getCharacterSilverCoinsInStorage($characterId);
		$orig_purse_cc = $this->getCharacterCopperCoinsInStorage($characterId);
		$purse_pc = $orig_purse_pc;
		$purse_gc = $orig_purse_gc;
		$purse_ec = $orig_purse_ec;
		$purse_sc = $orig_purse_sc;
		$purse_cc = $orig_purse_cc;
		echo "<br/>";		
		echo "purse_pc:".$purse_pc."<br/>";
		echo "purse_gc:".$purse_gc."<br/>";
		echo "purse_ec:".$purse_ec."<br/>";
		echo "purse_sc:".$purse_sc."<br/>";
		echo "purse_cc:".$purse_cc."<br/>";
		
		//pay off as much of debit in copper coins	
		$cc_spent = min($purse_cc,$debit_cc);
		$purse_cc -= $cc_spent;
		$debit_cc -= $cc_spent;
		echo "cc_spent:".$cc_spent."<br/>";	
		echo "debit_cc:".$debit_cc."<br/>";
		echo "purse_pc:".$purse_pc."<br/>";
		echo "purse_gc:".$purse_gc."<br/>";
		echo "purse_ec:".$purse_ec."<br/>";
		echo "purse_sc:".$purse_sc."<br/>";
		echo "purse_cc:".$purse_cc."<br/>";
				
		if($debit_cc > 0)
		{
			//Pay off as much of debit in silver coins
			$sc_factor = 10;
			$sc_spent = min($purse_sc,intval($debit_cc/$sc_factor));
			$purse_sc -= $sc_spent;
			$debit_cc -= ($sc_spent*$sc_factor);
			if(($debit_cc > 0) and ($purse_sc > 0))
			{
				//Try to make change if there are coins left
				$sc_spent += 1;
			   $purse_sc -= 1;   	
				$change = $sc_factor - $debit_cc;
				$debit_cc = 0;
				$purse_cc += $change;
			}			
			echo "sc_spent:".$sc_spent."<br/>";
			echo "debit_cc:".$debit_cc."<br/>";
			echo "purse_pc:".$purse_pc."<br/>";
			echo "purse_gc:".$purse_gc."<br/>";
			echo "purse_ec:".$purse_ec."<br/>";
			echo "purse_sc:".$purse_sc."<br/>";
			echo "purse_cc:".$purse_cc."<br/>";
					
			if($debit_cc > 0)
			{
				$ec_factor = 50;
				$ec_spent = min($purse_ec,intval($debit_cc/$ec_factor));
				$purse_ec -= $ec_spent;
				$debit_cc -= ($ec_spent*$ec_factor);
								
				if(($debit_cc > 0) and ($purse_ec > 0))
				{
					//Try to make change if there are coins left
					//Change will be distributed in denominations less than electrum
					$ec_spent += 1;
					$purse_ec -= 1;    	
					$change_cc = ($ec_factor - $debit_cc);
					$debit_cc = 0;					
					$purse_sc += intval($change_cc / $sc_factor);
					$purse_cc += $change_cc % $sc_factor;
				}				
				echo "ec_spent:".$ec_spent."<br/>";
				echo "debit_cc:".$debit_cc."<br/>"; 
				echo "purse_pc:".$purse_pc."<br/>";
				echo "purse_gc:".$purse_gc."<br/>";
				echo "purse_ec:".$purse_ec."<br/>";
				echo "purse_sc:".$purse_sc."<br/>";
				echo "purse_cc:".$purse_cc."<br/>";
						
				if($debit_cc > 0)
				{
					$gc_factor = 100;
					$gc_spent = min($purse_gc,intval($debit_cc/$gc_factor));
					$purse_gc -= $gc_spent;
					$debit_cc -= ($gc_spent*$gc_factor);
					if(($debit_cc > 0) and ($purse_gc > 0))
					{
						//Try to make change if there are coins left
						//Change will be distributed in denominations less than gold
						$gc_spent += 1;
						$purse_gc -= 1;
						$change_cc = ($gc_factor - $debit_cc);
						$debit_cc = 0;						
						$purse_ec += intval($change_cc / $ec_factor);
						$change_cc = ($change_cc % $ec_factor);
						$purse_sc += intval($change_cc / $sc_factor);
						$purse_cc += ($change_cc % $sc_factor);
					}
					echo "gc_spent:".$gc_spent."<br/>";
					echo "debit_cc:".$debit_cc."<br/>";
					echo "purse_pc:".$purse_pc."<br/>";
					echo "purse_gc:".$purse_gc."<br/>";
					echo "purse_ec:".$purse_ec."<br/>";
					echo "purse_sc:".$purse_sc."<br/>";
					echo "purse_cc:".$purse_cc."<br/>";
							
					if($debit_cc > 0)
					{
						$pc_factor = 500;
						$pc_spent = min($purse_pc,intval($debit_cc/$pc_factor));
						$purse_pc -= $pc_spent;
						$debit_cc -= ($pc_spent*$pc_factor);
						if(($debit_cc > 0) and ($purse_pc > 0))
						{
							//Try to make change if there are coins left
							//Change will be distributed in denominations less than platinum
							$pc_spent += 1;
							$purse_pc -= 1;
							$change_cc = ($pc_factor - $debit_cc);
							$debit_cc = 0;							
							$purse_gc += intval($change_cc / $gc_factor);
							$change_cc = ($change_cc % $gc_factor);
							$purse_ec += intval($change_cc / $ec_factor);
							$change_cc = ($change_cc % $ec_factor);
							$purse_sc += intval($change_cc / $sc_factor);
							$purse_cc += ($change_cc % $sc_factor); 	
						}
						echo "pc_spent:".$pc_spent."<br/>";
						echo "debit_cc:".$debit_cc."<br/>";
						echo "purse_pc:".$purse_pc."<br/>";
						echo "purse_gc:".$purse_gc."<br/>";
						echo "purse_ec:".$purse_ec."<br/>";
						echo "purse_sc:".$purse_sc."<br/>";
						echo "purse_cc:".$purse_cc."<br/>";
			
					}	
				}	
			}	
		}
		//Now adjust the characters purse (coins in storage)
		$destination = 1;//add or subtract to coins in storage				
		
		$coinId = 4;//Platinum coin id
		$quantityToAdd = $purse_pc - $orig_purse_pc;
		echo sprintf("Adding: %d %s coins", $quantityToAdd,"platinum");
		echo "<br/>";
		$this->addToCharacterCoins($characterId,$coinId,$quantityToAdd,$destination);
		
		$coinId = 1;//Gold coin id
		$quantityToAdd = $purse_gc - $orig_purse_gc;
		echo sprintf("Adding: %d %s coins", $quantityToAdd,"gold");
		echo "<br/>";		
		$this->addToCharacterCoins($characterId,$coinId,$quantityToAdd,$destination);
		
		$coinId = 5;//Electrum coin id
		$quantityToAdd = $purse_ec - $orig_purse_ec;
		echo sprintf("Adding: %d %s coins", $quantityToAdd,"electrum");
		echo "<br/>";
		$this->addToCharacterCoins($characterId,$coinId,$quantityToAdd,$destination);

		
		$coinId = 2;//Silver coin id
		$quantityToAdd = $purse_sc - $orig_purse_sc;
		echo sprintf("Adding: %d %s coins", $quantityToAdd,"silver");
		echo "<br/>";
		$this->addToCharacterCoins($characterId,$coinId,$quantityToAdd,$destination);
					
		$coinId = 3;//Copper coin id
		$quantityToAdd = $purse_cc - $orig_purse_cc;
		echo sprintf("Adding: %d %s coins", $quantityToAdd,"copper");
		echo "<br/>";
		$this->addToCharacterCoins($characterId,$coinId,$quantityToAdd,$destination);
	
	}
	
}

?>