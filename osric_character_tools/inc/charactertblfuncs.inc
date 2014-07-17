<?php
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
}
?>