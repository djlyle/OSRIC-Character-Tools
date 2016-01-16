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
	
	public function getTotalEncumbranceOnPerson($characterId)
	{
    $totalEncumbranceItemsCarried = osricdb_getTotalEncumbranceItemsCarried($this->cxn,$characterId);
    $totalEncumbranceCoinsCarried = osricdb_getTotalEncumbranceCoinsCarried($this->cxn,$characterId);
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
		$query = sprintf("SELECT i.ItemName,i.ItemEncumbrance,i.ItemCost,ci.Quantity,ci.Magic,ci.CharacterItemId,i.ItemId FROM character_items ci INNER JOIN weapons w ON ci.ItemId = w.ItemId INNER JOIN items i ON w.ItemId = i.ItemId WHERE ci.CharacterId = $characterId AND ci.ItemStatusId = '%s'",$itemStatus);
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
	
	private function getCharacterArmourByStatus($characterId, $itemStatus)
	{
		$query = sprintf("SELECT i.ItemName,a.ArmourEffectOnArmourClass,i.ItemEncumbrance,a.ArmourMovementRate,i.ItemCost,ci.Quantity,ci.Magic,ci.ItemStatusId,ci.CharacterItemId,i.ItemId FROM character_items ci INNER JOIN armour a ON ci.ItemId = a.ItemId INNER JOIN items i ON i.ItemId = a.ItemId WHERE ci.CharacterId = $characterId AND ci.ItemStatusId = '%s'",$itemStatus);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query:".$query);
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

	public function addToCharacterItems($characterId,$itemId,$quantityToAdd)
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
	
}

?>