<?php
/*Program: charactersheet.php
   Desc: Displays an existing character's attributes,abilities, equipment etc. in one sheet*/

$characterId = $_GET['CharacterId'];

include_once(dirname(__FILE__)."/inc/misc.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");
require_once(dirname(__FILE__)."/inc/Osric.php");

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$character_traits = $myOsricDb->getCharacterTraits($characterId);
$totalEncumbranceOnPerson = $myOsricDb->getTotalEncumbranceOnPerson($characterId);
$characterStatus = $myOsricDb->getCharacterStatus($characterId);

?>

<html>
<head>
<title>Character Sheet</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body class='clsPrintable'>
<div id='CharacterSheet'>
<?php
echo "<h3 class='cs_section_title'>PERSONAL STATS:</h3>\n";
echo "<table id='CharacterAttributes'>\n";
echo "<tr>";
echo "<td><div class='clsCellLabel'>Name:</div><div class='clsCellValue'>{$character['CharacterName']}</div></td>";
echo "<td><div class='clsCellLabel'>Full HP:</div><div class='clsCellValue'>{$characterStatus['CharacterStatusFullHitPoints']}</div></td>";
echo "</tr>\n";
echo "<tr>";
echo "<td><div class='clsCellLabel'>Class(es*):</div><div class='clsCellValue'>";
$characterClassesAsNames = $myOsricDb->getCharacterClassesAsNames($characterId);
$num_rows = count($characterClassesAsNames);
for($i=0;$i<$num_rows;$i++)
{
    if($i > 0)
    {
        echo ",";
    }     
    echo "{$characterClassesAsNames[$i]}";
    
}
echo "</div>";
echo "</td>";
echo "<td><div class='clsCellLabel'>Remaining HP:</div>";
echo "<div class='clsCellValue'>{$characterStatus['CharacterStatusRemainingHitPoints']}</div></td>";
echo "</tr>\n";
echo "<tr><td><div class='clsCellLabel'>XP:</div>";
echo "<div class='clsCellValue'>{$characterStatus['CharacterStatusExperiencePoints']}</div></td>";
echo "</tr>\n";
echo "</table>\n";

echo "<h3 class='cs_section_title'>PERSONAL TRAITS:</h3>\n";
echo "<table id='CharacterAttributes'>\n";
$num_traits = count($character_traits);
for($i = 0;$i < $num_traits;$i++){
	echo "<tr>";
	echo "<td><div class='clsCellLabel'>{$character_traits[$i]['DisplayName']}</div></td>";
	if($character_traits[$i]['data_type'] == 4)
	{
		$options = $myOsricDb->getOptions($character_traits[$i]['ChoiceTableName']);
		$value = $options[$character_traits[$i]['Value']];
	}
	else {
		$value = $character_traits[$i]['Value'];
	}
	echo "<td><div class='clsCellValue'>{$value}</div></td>";	
	echo "</tr>\n";
}
echo "</table>";

echo "<hr/>\n";

$character_abilities = $myOsricDb->getCharacterAbilities($characterId);

echo "<h3 class='cs_section_title'>ABILITIES:</h3>\n";
$num_abilities = count($character_abilities);
echo "<table id='CharacterAbilities'>\n";
for($i=0;$i<$num_abilities;$i++)
{
    echo "<tr><td>{$character_abilities[$i]['AbilityShortName']}: {$character_abilities[$i]['Value']}</td></tr>\n";
}
echo "</table>\n";

echo "<hr/>\n";

echo "<h3>Weapons & Armour</h3>\n";
echo "<div id='TotalEncumbrance'>Total Encumbrance (lbs): {$totalEncumbranceOnPerson}</div>\n";

$effectiveArmourClass = $myOsricDb->getCharacterEffectiveArmourClass($characterId);
echo "<div id='Effective Armour Class'>Effective Armour Class: {$effectiveArmourClass}</div>\n";

echo "<h4>Weapon(s) in Hand:</h4>\n";
echo "<table id='CharacterWeaponsInHand'>\n";
echo "<tr><td>Weapons</td><td>Melee Damage vs S-M</td><td>Melee Damage vs L</td><td>Missile Damage vs S-M</td><td>Missile Damage vs L</td><td>Missile Rate of Fire</td><td>Missile Range</td></tr>\n";
$character_weapons_in_use = $myOsricDb->getCharacterWeaponsInUse($characterId);
$num_rows = count($character_weapons_in_use);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_weapons_in_use[$i];
    $itemId = $row['ItemId'];
    $weapon = $myOsricDb->getWeapon($itemId);
    $weaponId = $weapon['WeaponId'];
    $weaponAsMelee = $myOsricDb->getWeaponAsMelee($weaponId);
    $weaponAsMeleeDmgVsSmallToMedium = Osric::getWeaponDmgVsSmallToMedium($weaponAsMelee);
    $weaponAsMeleeDmgVsLarge = Osric::getWeaponDmgVsLarge($weaponAsMelee);
    $weaponAsMissile = $myOsricDb->getWeaponAsMissile($weaponId);
    $weaponAsMissileDmgVsSmallToMedium = Osric::getWeaponDmgVsSmallToMedium($weaponAsMissile);
    $weaponAsMissileDmgVsLarge = Osric::getWeaponDmgVsLarge($weaponAsMissile);
    if($weaponAsMissile == null){
        $rateOfFire = "N\A";
        $rangeInFt = "N\A";
    }
    else{
        $rateOfFire = $weaponAsMissile['RateOfFire'];
        $rangeInFt = $weaponAsMissile['RangeInFt'];
    }    
    
    echo "<tr><td>{$row['ItemName']}({$row['Quantity']})</td><td>{$weaponAsMeleeDmgVsSmallToMedium}</td><td>{$weaponAsMeleeDmgVsLarge}</td><td>{$weaponAsMissileDmgVsSmallToMedium}</td><td>{$weaponAsMissileDmgVsLarge}</td><td>{$rateOfFire}</td><td>{$rangeInFt}</td></tr>";
}
echo "</table>\n";

echo "<h4>Weapons Carried:</h4>\n";
echo "<div id='CharacterWeaponsCarried'>\n";
$character_weapons_carried = $myOsricDb->getCharacterWeaponsCarried($characterId);
$num_rows = count($character_weapons_carried);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_weapons_carried[$i];
    if($i > 0)
    {
        echo "|";
    }
    echo "{$row['ItemName']}";
    echo "({$row['Quantity']})";
}
echo "</div>\n";

echo "<h4>Weapons In Storage:</h4>\n";
echo "<div id='CharacterWeaponsInStorage'>\n";
$character_weapons_in_storage = $myOsricDb->getCharacterWeaponsInStorage($characterId);
$num_rows = count($character_weapons_in_storage);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_weapons_in_storage[$i];
    if($i > 0)
    {
        echo "|";
    }
    echo "{$row['ItemName']}";
	echo "({$row['Quantity']})";
}	
echo "</div>\n";

echo "<h4>Armour Worn:</h4>\n";
echo "<table id='CharacterArmourWorn'>\n";
echo "<tr><td>Armour\\Protection (Quantity)</td></td><td>AC modifier</td></tr>\n";
$character_armour_worn = $myOsricDb->getCharacterArmourInUse($characterId);
$num_rows = count($character_armour_worn);
for($i=0;$i<$num_rows;$i++)
{
	$row = $character_armour_worn[$i];
	echo "<tr><td>{$row['ItemName']} ({$row['Quantity']})</td><td>{$row['ArmourEffectOnArmourClass']}</td></tr>\n";		
}

echo "</table>\n";

echo "<h4>Armour Carried:</h4>\n";
echo "<div id='CharacterArmourCarried'>\n";
$character_armour_carried = $myOsricDb->getCharacterArmourCarried($characterId);
$num_rows = count($character_armour_carried);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_armour_carried[$i];
    if($i > 0)
    {
        echo "|";
    }    
	echo "{$row['ItemName']}";
	echo "({$row['Quantity']})";
}	
echo "</div>\n";

echo "<h4>Armour In Storage:</h4>\n";
echo "<div id='CharacterArmourInStorage'>\n";
$character_armour_in_storage = $myOsricDb->getCharacterArmourInStorage($characterId);
$num_rows = count($character_armour_in_storage);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_armour_in_storage[$i];
    if($i > 0)
    {
        echo "|";
    }    
	echo "{$row['ItemName']}";
	echo "({$row['Quantity']})";
}
echo "</div>\n";

echo "<hr/>\n";

echo "<h3>Equipment</h3>\n";
echo "<h4>Equipment Carried:</h4>\n";

echo "<div id='CharacterEquipmentCarried'>\n";
$character_items_carried = $myOsricDb->getCharacterItemsCarried($characterId);
$num_rows = count($character_items_carried);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_items_carried[$i];
    if($i > 0)
    {
        echo "|";
    }
    echo"{$row['ItemName']}";
    echo"({$row['Quantity']})";	
}
echo "</div>\n";
echo "<h4>Equipment In Storage:</h4>";
echo "<div id='CharacterEquipmentInStorage'>\n";
$character_items_in_storage = $myOsricDb->getCharacterItemsInStorage($characterId);
$num_rows = count($character_items_in_storage);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_items_in_storage[$i];
    if($i > 0)
    {
        echo "|";
    }	
    echo "{$row['ItemName']}";
	echo "({$row['Quantity']})";
}	

echo "</div>\n";

?>
</div>
</body>
</html>	