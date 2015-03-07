<?php
/*Program: editcharacterabilities.php
   Desc: Edits an existing character's abilities in the osric_db*/

$CharacterId = $_GET['CharacterId'];

include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");

$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

$character = getCharacter($cxn,$CharacterId);

echo "Character Abilities for {$character['CharacterName']} (CharacterId={$CharacterId}):";
?>

<!-- Character form -->
<html>
<head>
<title>Edit Character Abilities</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<form action='submitcharacterabilities.php' method='post'>
<?php
echo "<input type='hidden' name='CharacterId' value='$CharacterId'/>";
echo "<table>";
$query = "SELECT * FROM character_abilities ca INNER JOIN abilities a on ca.AbilityId = a.AbilityId WHERE ca.CharacterId = $CharacterId";
$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
while($row = mysqli_fetch_assoc($result))
{
    echo "<tr>";
    echo "<td>{$row['AbilityLongName']}</td>";
    $abilityId = $row['AbilityId'];
	if($row['Value']){
		$value = $row['Value'];
	}
	else {
		$value = 0;
	}
	echo "<td><input type='number' min='0' max='9999999' name='editedAbility{$abilityId}' value='{$value}'></input></td>";    
    echo "</tr>";
}
echo "</table>";
?>
<div id="submit">
	<input type="submit" value="Submit Abilities"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	