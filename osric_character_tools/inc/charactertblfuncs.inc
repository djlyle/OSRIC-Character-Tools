<?php

function deleteCharacter($cxn,$characterId)
{
	if($characterId != -1)
	{
		/*TODO: make this a transaction.  Ideally this should all be one transaction that fails or succeeds as one atomic unit*/
		$query = sprintf("DELETE FROM `character_items` WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($cxn,$query) or die("Error in trying to delete a row in the character_items table.");
		$query = sprintf("DELETE FROM `characters` WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($cxn,$query) or die("Error in trying to delete a row in the characters table.");
        $query = sprintf("DELETE FROM `character_status` WHERE CharacterId='%s'",$characterId);
        $result = mysqli_query($cxn,$query) or die("Error in trying to delete a row in the character_status table.");
        $query = sprintf("DELETE FROM `character_abilities` WHERE CharacterId='%s'",$characterId);
        $result = mysqli_query($cxn,$query) or die("Error in trying to delete a row in the character_abilities table.");
        $query = sprintf("DELETE FROM `character_coins` WHERE CharacterId='%s'",$characterId);
        $result = mysqli_query($cxn,$query) or die("Error in trying to delete rows in the character_coins table.");
        deleteAllClassesForCharacter($cxn,$characterId);
	}
}

function getCharacterStatus($cxn,$characterId)
{
    $query = sprintf("SELECT * FROM `character_status` WHERE CharacterId='%s'",$characterId);
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterStatus query.");
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function editCharacterClasses($cxn,$characterId,$selectedCharacterClasses)
{
    deleteAllClassesForCharacter($cxn,$characterId);
    addClassesForCharacter($cxn,$characterId,$selectedCharacterClasses);
}

function getCharacterAbilities($cxn,$characterId)
{
    $query = sprintf("SELECT * FROM character_abilities ca INNER JOIN abilities a on ca.AbilityId = a.AbilityId WHERE ca.CharacterId = '%s'",$characterId);
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterAbilities query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;
}

function getCharacterClasses($cxn,$characterId)
{
    $query = sprintf("SELECT * FROM character_classes cc INNER JOIN classes c ON cc.ClassId = c.ClassId WHERE CharacterId='%s'",$characterId);
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getCharacterClasses query.");
    for($result_set = array();$row = mysqli_fetch_assoc($result);$result_set[]=$row);
    return $result_set;    
}

function addClassesForCharacter($cxn,$characterId,$selectedCharacterClasses)
{
    foreach($selectedCharacterClasses as $classId)
    {
        $query = "INSERT INTO character_classes (CharacterId,ClassId) VALUES ('{$characterId}','{$classId}')";
        $result = mysqli_query($cxn,$query) or die("Couldn't execute addClassesForCharacter query.");
    }
}

function deleteAllClassesForCharacter($cxn,$characterId)
{
    $query = sprintf("DELETE FROM character_classes WHERE CharacterId='%s'",$characterId);
    $result = mysqli_query($cxn,$query) or die("Couldn't execute deleteCharacterClasses query.");
    return $result;
}

function editCharacter($cxn,$character)
{
	$columnNames = array("CharacterName","CharacterAge","CharacterGender","CharacterWeight","CharacterHeight","RaceId");
	$characterId = $character['CharacterId'];
    
	if($characterId == -1)
	{
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
		$k=0;
		foreach($columnNames as $columnName)
		{
			if($k == 0)
			{
				$query = $query . "'" . $character[$columnName] . "'";
			}		
			else
			{
				$query = $query . "," . "'" . $character[$columnName] . "'";
			}
			$k = $k + 1;
		}
		$query = $query . ")";
	}
	else
	{
		/*edit an existing character*/
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
	}
	$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");

    if($characterId == -1)
    {
        $newCharacterId = mysqli_insert_id($cxn);        
        initCharacterCoinsToZero($cxn,$newCharacterId);
        initCharacterAbilitiesToZero($cxn,$newCharacterId);
        initCharacterStatusToZero($cxn,$newCharacterId);    
    }
}

function initCharacterStatusToZero($cxn,$characterId)
{
    /*Insert a new row in the character_status table with status fields zeroed out*/
    $query = "INSERT INTO character_status (CharacterId,CharacterStatusArmorClass,CharacterStatusExperiencePoints,CharacterStatusLevel,CharacterStatusFullHitPoints,CharacterStatusRemainingHitPoints) VALUE ('{$characterId}','0','0','0','0','0')";                                           
    $result = mysqli_query($cxn,$query) or die("Couldn't insert a new row in character_status table with status fields zeroed out.");
}


function initCharacterAbilitiesToZero($cxn,$characterId)
{
    /*Insert a new row in the character_abilities table with abilities zeroed out*/
    $query = "SELECT AbilityId FROM abilities";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute abilities query.");
    $k=0;
    while($row = mysqli_fetch_assoc($result))
    {
        $abilityIds[$k] = $row['AbilityId'];
        $k = $k + 1;
    }
    foreach($abilityIds as $abilityId)
    {
        $query = "INSERT INTO character_abilities (CharacterId,AbilityId,Value) VALUES ('{$characterId}','{$abilityId}','0')";
        $result = mysqli_query($cxn,$query) or die("Couldn't insert a new row in character_abilities table with abilities zeroed out.");
    }
}

function initCharacterCoinsToZero($cxn,$characterId)
{
    /*Insert zeroed out quantities of each coin type for the character in the character_coins table*/
    $query = "SELECT CoinId FROM coins";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute coins query.");   
    $k=0;    
    while($row = mysqli_fetch_assoc($result))
    {
        $coinIds[$k] = $row['CoinId'];
        $k = $k + 1;            
    }
    foreach($coinIds as $coinId)
    {
        $query = "INSERT INTO character_coins (CharacterId,CoinId,Quantity) VALUES ('{$characterId}','{$coinId}','0')";
        mysqli_query($cxn,$query) or die("Couldn't execute INSERT INTO character_coins with zero quantity value.");
    }    
}

function updateCharacterAbility($cxn, $characterId, $abilityId, $value)
{
    $query = "UPDATE character_abilities SET Value = '{$value}' WHERE character_abilities.CharacterId = {$characterId} AND character_abilities.AbilityId = {$abilityId}";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterAbility query.");
    return $result; 
}


function editCharacterStatus($cxn,$characterStatus)
{
	$columnNames = array("CharacterStatusArmorClass","CharacterStatusExperiencePoints","CharacterStatusLevel","CharacterStatusFullHitPoints","CharacterStatusRemainingHitPoints");
	$characterId = $characterStatus['CharacterId'];
    
	/*Check whether a row with id==$characterId exists in character_abilities table*/
    $query = sprintf("SELECT * FROM `character_status` WHERE CharacterId='%s'",$characterId);
	$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
    $row = mysqli_fetch_assoc($result);    
    if($row)
    {
        /*Edit an existing row in character_abilities*/
        $query = "UPDATE character_status ";
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
			$query = $query . "=" . "'" . $characterStatus[$columnName] . "'";
			$k = $k + 1;
		}
		
		$query = $query . " WHERE CharacterId = '{$characterId}'";    
    }
    	
	/*echo "query inside editCharacterStatus={$query}";*/
	$result = mysqli_query($cxn,$query) or die("Couldn't execute query to insert or update character_status table.");
}

?>