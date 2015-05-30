<?php
/*Program: charactersheet.php
   Desc: Displays an existing character's attributes,abilities, equipment etc. in one sheet*/

$characterId = $_GET['CharacterId'];

include_once("./inc/misc.inc");
include_once("./inc/charactertblfuncs.inc");
include_once("./inc/characterInventory.inc");
require_once("./inc/OsricDb.php");
require_once("./inc/Osric.php");

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);
$totalEncumbranceOnPerson = $myOsricDb->getTotalEncumbranceOnPerson($characterId);
$characterStatus = $myOsricDb->getCharacterStatus($characterId);

?>

<html>
<head>
<title>Character Sheet</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<?php
echo "<h3 class='cs_section_title'>PERSONAL ATTRIBUTES:</h3>\n";

echo "<table id='CharacterAttributes'>\n";
echo "<tr><td><div class='clsCellLabel'>Name:</div><div class='clsCellValue'>{$character['CharacterName']}</div></td><td><div class='clsCellLabel'>Age:</div><div class='clsCellValue'>{$character['CharacterAge']}</div></td><td><div class='clsCellLabel'>Full HP:</div><div class='clsCellValue'>{$characterStatus['CharacterStatusFullHitPoints']}</div></td></tr>\n";
echo "<tr><td><div class='clsCellLabel'>Class(es*):</div><div class='clsCellValue'>";
$characterClasses = $myOsricDb->getCharacterClasses($characterId);
$num_rows = count($characterClasses);
for($i=0;$i<$num_rows;$i++)
{
    if($i > 0)
    {
        echo ",";
    }     
    echo "{$characterClasses[$i]['ClassName']}";
    
}
echo "</div>";
echo "</td><td><div class='clsCellLabel'>Height:</div><div class='clsCellValue'>{$character['CharacterHeight']}</div></td><td><div class='clsCellLabel'>Remaining HP:</div><div class='clsCellValue'>{$characterStatus['CharacterStatusRemainingHitPoints']}</div></td></tr>\n";
echo "<tr><td><div class='clsCellLabel'>XP:</div><div class='clsCellValue'>{$characterStatus['CharacterStatusExperiencePoints']}</div></td></tr>";
echo "</table>\n";

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
echo "<h4>Weapon(s) in Hand:</h4>\n";
echo "<table id='CharacterWeaponsInHand'>\n";
echo "<tr><td>Weapons</td><td>Melee Damage vs S-M</td><td>Melee Damage vs L</td><td>Missile Damage vs S-M</td><td>Missile Damage vs L</td><td>Missile Rate of Fire</td><td>Missile Range</td></tr>\n";
$character_weapons_in_use = $myOsricDb->getCharacterWeaponsInUse($characterId);
$num_rows = count($character_weapons_in_use);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_weapons_in_use[$i];
    $weaponId = $row['WeaponId'];
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
    
    echo "<tr><td>{$row['WeaponType']}({$row['Quantity']})</td><td>{$weaponAsMeleeDmgVsSmallToMedium}</td><td>{$weaponAsMeleeDmgVsLarge}</td><td>{$weaponAsMissileDmgVsSmallToMedium}</td><td>{$weaponAsMissileDmgVsLarge}</td><td>{$rateOfFire}</td><td>{$rangeInFt}</td></tr>";
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
    echo "{$row['WeaponType']}";
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
    echo "{$row['WeaponType']}";
	echo "({$row['Quantity']})";
}	
echo "</div>\n";

echo "<h4>Armour Worn:</h4>\n";
echo "<table id='CharacterArmourWorn'>\n";
echo "<tr><td>Armour\\Protection</td><td>AC modifier</td></tr>\n";
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
	echo "{$row['ArmourType']}";
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
	echo "{$row['ArmourType']}";
	echo "({$row['Quantity']})";
}
echo "</div>\n";

echo "<hr/>\n";

echo "<h3>Equipment</h3>\n";
echo "<h4>Equipment Carried:</h4>";

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
</body>
</html>	