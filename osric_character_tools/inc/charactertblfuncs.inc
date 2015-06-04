<?php


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