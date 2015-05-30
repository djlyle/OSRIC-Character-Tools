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
    		echo "<td><input type='number' min='0' max='9999999' name='coin[{$index}][quantity]' value='{$coinQuantity}'></input></td>";    
    		echo "<td>";
			$transferSource = $row['ItemStatusId'];
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
}

?>