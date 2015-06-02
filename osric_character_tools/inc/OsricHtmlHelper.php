<?php
/*
Author: Daniel Lyle
Copyright: May 30,2015
*/
include_once("./functions.inc");

class OsricHtmlHelper
{
	public static function html_listbox($name, $options, $selected_value)
	{
    	echo "<select name='$name'>";
		foreach($options as $val=>$label)
		{
		echo "<option value='{$val}'";
		if($val == $selected_value)
		{
			echo "selected";
		}
		echo ">{$label}</option>";
		}
		echo "</select>";
	}
	
	public static function makeHtmlTableCharacterCoins($character_coins, $itemStatusOptions, $tableId, $offset)	
	{	
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Coin Name</td><td>Quantity</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>\n";
		
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
    		echo "<td>";
			static::html_listbox("coin[{$index}][transferDestination]", $itemStatusOptions, $transferSource);
    		echo "</td>";
    		echo "<td><input type='number' min='0' max='{$coinQuantity}' name='coin[{$index}][transferQuantity]' value='0'></input></td>";
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='coin[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='coin[{$index}][coinId]' value='{$coinId}'></input></td>";
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='coin[{$index}][characterCoinId]' value='{$characterCoinId}'></input></td>";    
    		echo "</tr>\n";
		}
		echo "</table>\n";
	}


	public static function makeHtmlTableCharacterArmour($character_armour, $itemStatusOptions, $tableId, $offset)	
	{	
		$num_rows = count($character_armour);
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Armour Type</td><td>Effect on Armour Class</td><td>Encumbrance</td><td>Movement Rate</td><td>Cost</td><td>Quantity</td><td>Magic</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>\n";
		
		for($i=0;$i<$num_rows;$i++)
		{
			$row = $character_armour[$i];
			echo "<tr>";
			echo "<td>{$row['ArmourType']}</td>";
			echo "<td>{$row['ArmourEffectOnArmourClass']}</td>";
			echo "<td>{$row['ArmourEncumbrance']}</td>";
			echo "<td>{$row['ArmourMovementRate']}</td>";
			echo "<td>{$row['ArmourCost']}</td>";
			$characterArmourId = $row['CharacterArmourId'];
			$armourId = $row['ArmourId'];    
    	
			if($row['Quantity']){
				$armourQuantity = $row['Quantity'];
			}
			else {
				$armourQuantity = 0;
			}
			$armourMagic = $row['ArmourMagic'];
			$transferSource = $row['EquipmentStatusId'];
			$index = $offset + $i;
			echo "<td><input type='number' min='0' max='9999999' name='armour[{$index}][quantity]' value='{$armourQuantity}' readonly='readonly'></input></td>";
			echo "<td><input type='number' min='0' max='9999999' name='armour[{$index}][armourMagic]' value='{$armourMagic}' readonly='readonly'></input></td>";	
			echo "<td>";
			static::html_listbox("armour[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);
			echo "</td>";    
			echo "<td><input type='number' min='0' max='{$armourQuantity}' name='armour[{$index}][transferQuantity]' value='0'></input></td>";
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='armour[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='armour[{$index}][armourId]' value='{$armourId}'></input></td>";    
			echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='armour[{$index}][characterArmourId]' value='{$characterArmourId}'></input></td>";    
			echo "</tr>\n";
		}
		echo "</table>\n";
	}

	public static function makeHtmlTableCharacterWeapons($character_weapons, $itemStatusOptions, $tableId, $offset)
	{
		$num_rows = count($character_weapons);
		echo "<table id='{$tableId}'>\n";
		echo "<tr><td>Weapon Type</td><td>Encumbrance (lbs)</td><td>Cost (gp)</td><td>Quantity</td><td>Magic</td><td>Transfer Destination</td><td>Transfer Quantity</td></tr>";
		$offset = 0;
		for($i=0;$i<$num_rows;$i++)
		{
			$row = $character_weapons[$i];
			echo "<tr>";
			echo "<td>{$row['WeaponType']}</td>";
			echo "<td>{$row['WeaponEncumbranceInLbs']}</td>";
			echo "<td>{$row['WeaponCost']}</td>";
			$characterWeaponId = $row['CharacterWeaponId'];
			$weaponId = $row['WeaponId'];
	
			if($row['Quantity']){
				$weaponQuantity = $row['Quantity'];
			}
			else {
				$weaponQuantity = 0;
			}
    		$weaponMagic = $row['WeaponMagic'];
    		$transferSource = $row['EquipmentStatusId'];
    		$index = $offset + $i;
		
    		echo "<td><input type='number' min='0' max='9999999' name='weapon[{$index}][quantity]' value='{$weaponQuantity}' readonly='readonly'></input></td>";
    		echo "<td><input type='number' min='0' max='9999999' name='weapon[{$index}][weaponMagic]' value='{$weaponMagic}' readonly='readonly'></input></td>";	
    		echo "<td>";
    		static::html_listbox("weapon[{$index}][transferDestination]", $equipmentStatusOptions, $transferSource);        
    		echo "</td>";      
    		echo "<td><input type='number' min='0' max='{$weaponQuantity}' name='weapon[{$index}][transferQuantity]' value='0'></input></td>";
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='weapon[{$index}][transferSource]' value='{$transferSource}'></input></td>";    
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='weapon[{$index}][weaponId]' value='{$weaponId}'></input></td>";    
    		echo "<td class='clsDisplayNone'><input type='hidden' min='0' max='9999999' name='weapon[{$index}][characterWeaponId]' value='{$characterWeaponId}'></input></td>";    
    		echo "</tr>\n";
		}
		echo "</table>\n";
	}
}

?>