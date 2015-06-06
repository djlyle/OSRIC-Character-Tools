<?php


function updateCharacterAbility($cxn, $characterId, $abilityId, $value)
{
    $query = "UPDATE character_abilities SET Value = '{$value}' WHERE character_abilities.CharacterId = {$characterId} AND character_abilities.AbilityId = {$abilityId}";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterAbility query.");
    return $result; 
}

?>