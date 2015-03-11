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

$query = "SELECT * FROM character_classes WHERE CharacterId = $CharacterId";
$result = mysqli_query($cxn,$query) or die("Couldn't execute character_classes query.");
while($row = mysqli_fetch_assoc($result))
{
    $selectedClasses[$row['ClassId']] = true;
}

$query = "SELECT * FROM classes";
$result = mysqli_query($cxn,$query) or die("Couldn't execute classes query.");
while($row = mysqli_fetch_assoc($result))
{    
    $classId = $row['ClassId'];
    $className = $row['ClassName'];  
    echo "<label>";
    echo "<input type='checkbox' name='characterClass[]' value='{$classId}'";
    if($selectedClasses[$classId])
    {
        echo " checked='checked'";        
    }
    echo "/>";
    echo "{$className}";
    echo "</label><br/>";
}

?>
<div id="submit">
	<input type="submit" value="Submit Classes"/>
	<input type="submit" name="cancelbutton" value="Cancel"/>
</div>
</form>
</body>
</html>	