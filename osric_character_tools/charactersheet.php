<?php
/*Program: charactersheet.php
   Desc: Displays an existing character's attributes,abilities, equipment etc. in one sheet*/

$CharacterId = $_GET['CharacterId'];
echo "Character with CharacterId={$CharacterId}";

include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");

$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

$character = getCharacter($cxn,$CharacterId);
$characterStatus = getCharacterStatus($cxn,$CharacterId);

$labels = array("CharacterName"=>"Name","CharacterGender"=>"Gender","CharacterAge"=>"Age (years)","CharacterWeight"=>"Weight (lbs)","CharacterHeight"=>"Height (inches)","RaceId"=>"Race");

?>

<html>
<head>
<title>Character Sheet</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<?php
echo "<h3>PERSONAL ATTRIBUTES:</h3>\n";
echo "<table id='personal_attributes'>\n";
echo "<tr><td>Name: {$character['CharacterName']}</td><td>XP: {$characterStatus['CharacterStatusExperiencePoints']}</td><td>Age: {$character['CharacterAge']}</td><td>Height: {$character['CharacterHeight']}</td></tr>\n";
echo "<tr><td>Class(es*): ";
$result_set = getCharacterClasses($cxn,$CharacterId);
$num_rows = count($result_set);
for($i=0;$i<$num_rows;$i++)
{
    if($i > 0)
    {
        echo ",";
    }     
    echo "{$result_set[$i]['ClassName']}";
    
}
echo "</td><td>Full HP: {$characterStatus['CharacterStatusFullHitPoints']}</td><td>Remaining HP: {$characterStatus['CharacterStatusRemainingHitPoints']}</td></tr>\n";
echo "</table>";
?>
</body>
</html>	