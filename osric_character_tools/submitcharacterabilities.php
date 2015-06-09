<?php
include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$characterId = $_POST['CharacterId'];
/*If the cancel button was pressed in the form from editcharacter.php
  then return to characters.php */
if(@$_POST['cancelbutton'] == "Cancel")
{
	header("Location: characters.php");
    exit();
}

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);

$editedAbilityTag = "editedAbility";
$editedAbilityTagLen = strlen($editedAbilityTag);
foreach($_POST as $field => $value)
{
	/*Check if the name of the element in the POST array begins with "editedItem".  If it does then
	   insert its value into the character_items table using the passed over characterId*/
	
	if(strpos($field,$editedAbilityTag) === 0)
	{
		/*extract abilityId from $field name, e.g. if $field="editedAbility3" then abilityId == 3*/
		$abilityIdLen = strlen($field) - $editedAbilityTagLen;
		$abilityId = substr($field,$editedAbilityTagLen,$abilityIdLen);
		$abilityValue = trim($value);
		
		$result = $myOsricDb->updateCharacterAbility($characterId, $abilityId, $abilityValue);
        
	}    
}

echo "<p>Character abilities updated.</p>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>