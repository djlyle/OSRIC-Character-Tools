<?php
/*
Author: Daniel Lyle
Copyright: May 30,2015
*/

class Osric
{
   public static function getWeaponDmgVsSmallToMedium($weapon)
	{
		if($weapon == null) return "N\A";
		
		$modifier = $weapon['DamageModifierVsSmallOrMedium'];
		$modifierStr = "";
		if($modifier > 0)
		{
			$modifierStr = "+".$modifier;
		}
		return "".$weapon['DamageVsSmallOrMediumMultiples']."d".$weapon['DamageVsSmallOrMedium'].$modifierStr;
	}

	public static function getWeaponDmgVsLarge($weapon)
	{
		if($weapon == null) return "N\A";
		
		$modifier = $weapon['DamageModifierVsLarge'];
		$modifierStr = "";
		if($modifier > 0)
		{
			$modifierStr = "+".$modifier;
		}
		return "".$weapon['DamageVsLargeMultiples']."d".$weapon['DamageVsLarge'].$modifierStr;
	}
}

?>