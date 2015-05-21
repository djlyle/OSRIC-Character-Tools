<?php
/*Program: charactersheet.php
   Desc: Displays an existing character's attributes,abilities, equipment etc. in one sheet*/

$characterId = $_GET['CharacterId'];

include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
include("./inc/characterInventory.inc");

$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

$character = getCharacter($cxn,$characterId);
$characterStatus = getCharacterStatus($cxn,$characterId);
$totalEncumbranceOnPerson = osricdb_getTotalEncumbranceOnPerson($cxn, $characterId);
$labels = array("CharacterName"=>"Name","CharacterGender"=>"Gender","CharacterAge"=>"Age (years)","CharacterWeight"=>"Weight (lbs)","CharacterHeight"=>"Height (inches)","RaceId"=>"Race");

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
$result_set = getCharacterClasses($cxn,$characterId);
$num_rows = count($result_set);
for($i=0;$i<$num_rows;$i++)
{
    if($i > 0)
    {
        echo ",";
    }     
    echo "{$result_set[$i]['ClassName']}";
    
}
echo "</span>";
echo "</td><td><div class='clsCellLabel'>Height:</div><div class='clsCellValue'>{$character['CharacterHeight']}</div></td><td><div class='clsCellLabel'>Remaining HP:</div><div class='clsCellValue'>{$characterStatus['CharacterStatusRemainingHitPoints']}</div></td></tr>\n";
echo "<tr><td><div class='clsCellLabel'>XP:</div><div class='clsCellValue'>{$characterStatus['CharacterStatusExperiencePoints']}</div></td></tr>";
echo "</table>\n";

echo "<hr/>\n";

$character_abilities = getCharacterAbilities($cxn,$characterId);

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
$character_weapons_in_use = osricdb_getCharacterWeaponsInUse($cxn, $characterId);
$num_rows = count($character_weapons_in_use);
for($i=0;$i<$num_rows;$i++)
{
    $row = $character_weapons_in_use[$i];
    $weaponAsMelee = osricdb_getWeaponAsMelee($cxn, $row['WeaponId']);
    $weaponAsMeleeDmgVsSmallToMedium = osric_getWeaponDmgVsSmallToMedium($weaponAsMelee);
    $weaponAsMeleeDmgVsLarge = osric_getWeaponDmgVsLarge($weaponAsMelee);
    $weaponAsMissile = osricdb_getWeaponAsMissile($cxn, $row['WeaponId']);
    $weaponAsMissileDmgVsSmallToMedium = osric_getWeaponDmgVsSmallToMedium($weaponAsMissile);
    $weaponAsMissileDmgVsLarge = osric_getWeaponDmgVsLarge($weaponAsMissile);
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
$character_weapons_carried = osricdb_getCharacterWeaponsCarried($cxn,$characterId);
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
$character_weapons_in_storage = osricdb_getCharacterWeaponsInStorage($cxn,$characterId);
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
$character_armour_carried = osricdb_getCharacterArmourCarried($cxn,$characterId);
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
$character_armour_in_storage = osricdb_getCharacterArmourInStorage($cxn,$characterId);
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
$character_items_carried = osricdb_getCharacterItemsCarried($cxn,$characterId);
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
$character_items_in_storage = osricdb_getCharacterItemsInStorage($cxn,$characterId);
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