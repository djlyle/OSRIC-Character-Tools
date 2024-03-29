<?php
/*
File: OsricHtmlHelper.php
Author: Daniel Lyle
Copyright: May 30,2015
*/

class OsricHtmlHelper
{
	public static function html_listbox($name, $options, $selected_value)
	{
    	echo "<select name='$name'>\n";
		foreach($options as $val=>$label)
		{
		echo "<option value='{$val}'";
		if($val == $selected_value)
		{
			echo "selected";
		}
		echo ">{$label}</option>\n";
		}
		echo "</select>\n";
	}
	
	public static function makeHtmlTableCharacterCoins($character_coins, $itemStatusOptions, $tableId, $offset)	
	{	
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Coin Name</td><td>Quantity</td><td>Transfer Quantity</td></tr>\n";
		
		$num_rows = count($character_coins);
		
		for($i=0;$i<$num_rows;$i++)
		{
    		$row = $character_coins[$i];
    		$index = $offset + $i;
			
			
			echo "<tr>";
    		echo "<td>{$row['CoinName']}</td>";
    		$coinId = $row['CoinId'];
    		$characterCoinId = $row['CharacterCoinId'];	
			    		
    		if($row['Quantity']){
				$coinQuantity = $row['Quantity'];
			}
			else {
				$coinQuantity = 0;
			}
			
			$transferSource = $row['ItemStatusId'];
    		
    		echo "<td><input type='number' min='0' max='9999999' name='coin[{$index}][quantity]' value='{$coinQuantity}'></input></td>";    
    		echo "<td><input type='number' min='0' max='{$coinQuantity}' name='coin[{$index}][transferQuantity]' value='0'></input></td>";
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='coin[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='coin[{$index}][coinId]' value='{$coinId}'></input></td>";
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='coin[{$index}][characterCoinId]' value='{$characterCoinId}'></input></td>";    
    		echo "</tr>\n";
		}
		echo "</table>\n";
	}
	
	public static function makeHtmlTableCoinsTreasure($tableId,$coinNamesAndIds)
	{
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Coin Name</td><td>Quantity</td></tr>\n";
		$index = 0;
		foreach($coinNamesAndIds as $coinName => $coinId)
		{
			echo "<tr>";			
			echo "<td>";
			echo "{$coinName}";
			echo "</td>";			
			echo "<td><input type='number' min='0' max='9999999' name='coin[{$index}][quantity]' value='0'></input></td>";    			
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='coin[{$index}][coinId]' value='{$coinId}'></input></td>";			
			echo "</tr>";			
			$index += 1;		
		}			
		echo "</table>\n";
		
	} 
	
	public static function makeHtmlTableExperiencePoints($tableId)
	{
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Experience Points to Add:</td><td><input type='number' min='0' max='9999999' name='experiencePtsToAdd' value='0'></input></td></tr>\n";
		echo "</table>\n";
	}


	public static function makeHtmlTableCharacterArmour($character_armour, $itemStatusOptions, $tableId, $offset)	
	{	
		$num_rows = count($character_armour);
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Armour Type</td><td>Effect on Armour Class</td><td>Encumbrance</td><td>Movement Rate</td><td>Cost</td><td>Quantity</td><td>Magic</td><td>Transfer Quantity</td></tr>\n";
		
		for($i=0;$i<$num_rows;$i++)
		{
			$row = $character_armour[$i];
			echo "<tr>";
			echo "<td>{$row['ItemName']}</td>";
			echo "<td>{$row['ArmourEffectOnArmourClass']}</td>";
			echo "<td>{$row['ItemEncumbrance']}</td>";
			echo "<td>{$row['ArmourMovementRate']}</td>";
			echo "<td>{$row['ItemCost']}</td>";
			$characterItemId = $row['CharacterItemId'];
			$itemId = $row['ItemId'];    
    	
			if($row['Quantity']){
				$itemQuantity = $row['Quantity'];
			}
			else {
				$itemQuantity = 0;
			}
			$itemMagic = $row['Magic'];
			$transferSource = $row['ItemStatusId'];
			$index = $offset + $i;
			echo "<td>{$itemQuantity}</td>";
			echo "<td><input type='number' min='0' max='9999999' name='item[{$index}][itemMagic]' value='{$itemMagic}' readonly='readonly'></input></td>";	
			echo "<td><input type='number' min='0' max='{$itemQuantity}' name='item[{$index}][transferQuantity]' value='0'></input></td>";
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][quantity]' value='{$itemQuantity}'></input></td>";
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][itemId]' value='{$itemId}'></input></td>";    
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][characterItemId]' value='{$characterItemId}'></input></td>";    
			echo "</tr>\n";
		}
		echo "</table>\n";
	}

	public static function makeHtmlTableCharacterWeapons($character_weapons, $itemStatusOptions, $tableId, $offset)
	{
		$num_rows = count($character_weapons);
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Weapon Type</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Magic</td><td>Transfer Quantity</td></tr>";
		for($i=0;$i<$num_rows;$i++)
		{
			$row = $character_weapons[$i];
			echo "<tr>";
			echo "<td>{$row['ItemName']}</td>";
			echo "<td>{$row['ItemEncumbrance']}</td>";
			echo "<td>{$row['ItemCost']}</td>";
			$characterItemId = $row['CharacterItemId'];
			$itemId = $row['ItemId'];
	
			if($row['Quantity']){
				$itemQuantity = $row['Quantity'];
			}
			else {
				$itemQuantity = 0;
			}
    		$itemMagic = $row['Magic'];
    		$transferSource = $row['ItemStatusId'];
    		$index = $offset + $i;
		
    		echo "<td>{$itemQuantity}</td>";
    		echo "<td><input type='number' min='0' max='9999999' name='item[{$index}][itemMagic]' value='{$itemMagic}' readonly='readonly'></input></td>";	
    		echo "<td><input type='number' min='0' max='{$itemQuantity}' name='item[{$index}][transferQuantity]' value='0'></input></td>";
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][quantity]' value='{$itemQuantity}'></input></td>";
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][itemId]' value='{$itemId}'></input></td>";    
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][characterItemId]' value='{$characterItemId}'></input></td>";    
    		echo "</tr>\n";
		}
		echo "</table>\n";
	}
	
	public static function makeHtmlTableCharacterEquipment($character_items, $itemStatusOptions, $tableId, $offset)
	{
		$num_rows = count($character_items);
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Item Name</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Transfer Quantity</td></tr>";		
		for($i=0;$i<$num_rows;$i++)
		{
			$row = $character_items[$i];
			echo "<tr>";
			echo "<td>{$row['ItemName']}</td>";
			echo "<td>{$row['ItemEncumbrance']}</td>";
			echo "<td>{$row['ItemCost']}</td>";
			$transferSource = $row['ItemStatusId'];
			$characterItemId = $row['CharacterItemId'];
			$itemId = $row['ItemId'];
			$index = $offset + $i;
		
			if($row['Quantity'])
			{
				$itemQuantity = $row['Quantity'];
			}
			else 
			{
				$itemQuantity = 0;
			}
			echo "<td>{$itemQuantity}</input></td>";
			echo "<td><input type='number' min='0' max='{$itemQuantity}' name='item[{$index}][transferQuantity]' value='0'></input></td>";
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][quantity]' value='{$itemQuantity}'></input></td>";
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][itemId]' value='{$itemId}'></input></td>";
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='item[{$index}][characterItemId]' value='{$characterItemId}'></input></td>";     
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	
	public static function makeHtmlTableItemsToPurchase($items, $tableId, $offset)
	{
		$num_rows = count($items);

		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Item Name</td><td>Encumbrance (gp)</td><td>Cost (gp)</td><td>Quantity</td></tr>\n";

		for($i=0;$i<$num_rows;$i++)
		{
			$row = $items[$i];
			$index = $offset + $i;
			echo "<tr>";
			echo "<td>{$row['ItemName']}</td>";
			echo "<td>{$row['ItemEncumbrance']}</td>";
			echo "<td>{$row['ItemCost']}</td>";
			$itemId = $row['ItemId'];
			echo "<td><input type='number' min='0' max='9999999' name='item[{$index}][quantity]' value='0'></input></td>";
			echo "<td class='clsDisplayNone'><input type='hidden' name='item[{$index}][itemId]' value='{$itemId}'></input></td>";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	
	public static function makeHtmlCharacterClasses($classes,$characterClasses)
	{
		foreach($classes as $row)
		{    
    		$classId = $row['ClassId'];
    		$className = $row['ClassName'];  
    		echo "<label class='clsCharacterClass'>";
    		echo "<input type='checkbox' name='characterClass[]' value='{$classId}'";
    		if(in_array($classId,$characterClasses))
    		{
        		echo " checked='checked'";        
    		}
    		echo "/>";
    		echo "{$className}";
    		echo "</label><br/>\n";
		}
	}
	
	public static function makeHtmlTableCharacterAbilities($character_abilities)
	{
		echo "<table class='clsPropertiesTbl'>";
		$num_abilities = count($character_abilities);
		for($i=0;$i<$num_abilities;$i++)
		{
			echo "<tr>";
			echo "<td>{$character_abilities[$i]['AbilityLongName']}</td>";
			$abilityId = $character_abilities[$i]['AbilityId'];
			if($character_abilities[$i]['Value']){
				$value = $character_abilities[$i]['Value'];
			}
			else {
				$value = 0;
			}
			echo "<td><input type='number' min='0' max='9999999' name='editedAbility{$abilityId}' value='{$value}'></input></td>";    
			echo "</tr>";
		}
		echo "</table>";
	}
	
	public static function makeHtmlTableCharacterStatus($character_status)
	{
		$num_columns = count($character_status);
		echo "<table class='clsPropertiesTbl'>\n";
		
		for($i=0;$i<$num_columns;$i++)
		{
			echo "<tr>";
			echo "<td>{$character_status[$i]['DisplayName']}</td>";
			$statusId = $character_status[$i]['StatusId'];
			if($character_status[$i]['Value']){
				$value = $character_status[$i]['Value'];
			}
			else {
				$value = 0;
			}
			echo "<td><input type='number' min='0' max='9999999' name='characterstatus[{$i}][value]' value='{$value}'></input></td>";    
			echo "<td class='clsDisplayNone'><input type='hidden' name='characterstatus[{$i}][statusId]' value='{$statusId}'></input></td>";
			echo "</tr>\n";
		}
		echo "</table>";
	}
	
	public static function makeHtmlTableRowsForCharacterTraits($character_traits,$m_OsricDb)
	{
		$num_columns = count($character_traits);
		
		for($i=0;$i<$num_columns;$i++)
		{
			echo "<tr>\n";
			echo "<td>{$character_traits[$i]['DisplayName']}</td>\n";
			$traitId = $character_traits[$i]['TraitId'];
			if($character_traits[$i]['Value']){
				$value = $character_traits[$i]['Value'];
			}
			else {
				$value = 0;
			}
			$dataType = $character_traits[$i]['data_type'];
			$name = sprintf("charactertraits[%d][value]",$i);
			switch($dataType)
			{
				case 0:
					//datatype = 0 (string):
					echo "<td><input type='text' name='{$name}' value='$value'></input></td>\n";
				break;
				case 2:
					//datatype = 2 (float)
					echo "<td><input type='number' name='{$name}' min='0' step='any' value='$value'></input></td>";
				break;
				case 4:
					//datatype = 4 (choice)
					$optionsTableName = $character_traits[$i]['ChoiceTableName'];			
					$options = $m_OsricDb->getOptions($optionsTableName);
					echo "<td>";			
					OsricHtmlHelper::html_listbox($name, $options, $value);
					echo "</td>";
            break;				
			}
			echo "<td class='clsDisplayNone'><input type='hidden' name='charactertraits[{$i}][traitId]' value='{$traitId}'></input></td>\n";			
			echo "</tr>\n";
		}
	}
}

?>