<?php
/*Program: editcharacterclasses.php
   Desc: Edits an existing character's classes in the osric_db*/

$CharacterId = $_GET['CharacterId'];

include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");

$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

echo "Getting character...";
$character = getCharacter($cxn,$CharacterId);

echo "Character Classes for {$character['CharacterName']} (CharacterId={$CharacterId}):";
?>

<!-- Character Classes form -->
<html>
<head>
<title>Edit Character Classes</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<form action='submitcharacterclasses.php' method='post'>
<?php
echo "<input type='hidden' name='CharacterId' value='$CharacterId'/>";
echo "<select name='character_classes' multiple='multiple'>";


$query = "SELECT * FROM classes c LEFT OUTER JOIN character_classes cc ON c.ClassId = cc.ClassId WHERE cc.CharacterId = $CharacterId OR cc.CharacterId IS NULL";
$result = mysqli_query($cxn,$query) or die("Couldn't execute left outer join on character_classes with classes table query.");
echo "<option value='-1'>Wonky</option>";
while($row = mysqli_fetch_assoc($result))
{
    $classId = $row['ClassId'];
if($classId)
{
    echo "<option value='-2'>Willy</option>";
}
else
{
    echo "<option value='-3'>Bar</option>";
}
    echo "classId=";
    echo "{$classId}";
/*    
    echo "<option value='{$classId}'";
    if($row['CharacterId'])
    {
        echo " selected='selected'";        
    }
    echo ">";
    echo "{$row['ClassName']}";
    echo "</option>";
*/
}

echo "</select>";
?>
<div id="submit">
	<input type="submit" value="Submit Classes"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	