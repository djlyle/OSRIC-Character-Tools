<?php
/*Program: editcharacter.php
   Desc: Edits an existing character or adds a new character to the Characters table in the osric_db*/

$CharacterId = $_GET['CharacterId'];
echo "Character with CharacterId={$CharacterId}";

include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");

$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

if($CharacterId != -1)
{
	$character = getCharacter($cxn,$CharacterId);
}
$labels = array("CharacterName"=>"Name","CharacterGender"=>"Gender","CharacterAge"=>"Age (years)","CharacterWeight"=>"Weight (lbs)","CharacterHeight"=>"Height (inches)","RaceId"=>"Race");
$inputTypes = array("CharacterName"=>"text","CharacterGender"=>"select","CharacterAge"=>"float","CharacterWeight"=>"float","CharacterHeight"=>"float","RaceId"=>"select");
$selectOptions['CharacterGender'][0] = "Unknown";
$selectOptions['CharacterGender'][1] = "Male";
$selectOptions['CharacterGender'][2] = "Female";
$k=0;
$query = "SELECT * FROM races";
$result = mysqli_query($cxn,$query) or die("Couldn't execute races query.");
while($row = mysqli_fetch_assoc($result))
{
    $selectOptions['RaceId'][$k] = $row['RaceName'];
    $k = $k + 1;
}
?>

/*Character form*/
<html>
<head>
<title>Edit Character</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<form action='submitcharacter.php' method='post'>
<?php
echo "<input type='hidden' name='CharacterId' value='$CharacterId'/>";
echo "<table>";
foreach($labels as $field => $label)
{
	echo "<tr>";
	echo "<td>";
	echo "<label for='$field'>$label</label>";
	echo "</td>";
	if($CharacterId != -1)
	{
		$value = $character[$field];	
	}
	else
	{
		$value = "";	
	}
	echo "<td>";
	$inputType = $inputTypes[$field];
	switch($inputType)
	{
		case "text":
			echo "<input type='text' name='$field' value='$value'/>";
		break;
		case "select":
			echo "<select name='$field'>";
			foreach($selectOptions[$field] as $val=>$label)
			{
				echo "<option value='{$val}'";
				if($val == $value)
				{
					echo "selected";
				}
				echo ">{$label}</option>";
				
			}
			echo "</select>";
		break;
		case "float":
			echo "<input type='number' name='$field' min='0' step='any' value='$value'/>";
		break;
		
	}
	echo "</td>";
	echo "</tr>";
}
echo "</table>";
?>
<div id="submit">
	<input type="submit" value="Submit Character"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	