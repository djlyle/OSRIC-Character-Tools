<?php
include_once("./misc.inc");

class OsricDb
{
  
	protected $cxn;
	
	public function doInit($aHost,$aUser,$aPasswd)
	{
		$aDbname = "osric_db";
		$this->cxn = mysqli_connect($aHost,$aUser,$aPasswd,$aDbname) or die("Couldn't connect to server");
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
	
}

?>