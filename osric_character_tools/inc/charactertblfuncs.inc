<?php

 function deleteCharacter($cxn,$characterId)
{
	if($characterId != -1)
	{
		/*TODO: make this a transaction.  Ideally this should all be one transaction that fails or succeeds as one atomic unit*/
		$query = sprintf("DELETE FROM `character_items` WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
		$query = sprintf("DELETE FROM `characters` WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
	}
}

 function getCharacter($cxn,$characterId)
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
		$query = sprintf("SELECT * FROM `characters` WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
		$row = mysqli_fetch_assoc($result);
	}
	return $row; 
}

function editCharacter($cxn,$character)
{
	$columnNames = array("CharacterName","CharacterAge","CharacterGender","CharacterWeight","CharacterHeight");
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
?>