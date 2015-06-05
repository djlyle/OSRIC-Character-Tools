<?php
/*
  Author: Daniel Lyle
  Copyright: June 4,2015
  Program: editcharacterclasses.php
 *Desc: Edits an existing character's classes in the osric_db
 */

$characterId = $_GET['CharacterId'];

include_once(dirname(__FILE__)."/inc/misc.inc");
include_once(dirname(__FILE__)."/inc/charactertblfuncs.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");
$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);
$character = $myOsricDb->getCharacter($characterId);

echo "Character Classes for {$character['CharacterName']} (CharacterId={$characterId}):";
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
echo "<input type='hidden' name='CharacterId' value='$characterId'/>";

$characterClasses = $myOsricDb->getCharacterClasses($characterId);

$classes = $myOsricDb->getClasses();
foreach($classes as $row)
{    
    $classId = $row['ClassId'];
    $className = $row['ClassName'];  
    echo "<label>";
    echo "<input type='checkbox' name='characterClass[]' value='{$classId}'";
    if(in_array($classId,$characterClasses))
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