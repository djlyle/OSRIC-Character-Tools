<?php
/*Program: deletecharacter.php
   Desc: Deletes an existing character in the Characters table and related tables in the osric_db*/

include_once(dirname(__FILE__)."/inc/misc.inc");
include_once(dirname(__FILE__)."/inc/charactertblfuncs.inc");
require_once(dirname(__FILE__)."/inc/OsricDb.php");

$characterId = $_GET['CharacterId'];
echo "Deleting Character with CharacterId={$characterId}";

$myOsricDb = new OsricDb();
$myOsricDb->doInit($host,$user,$passwd);

if($characterId != -1)
{
	$character = $myOsricDb->getCharacter($characterId);

	$myOsricDb->deleteCharacter($characterId);
}

?>

/*Character form*/
<html>
<head>
<title>Deleting Character</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<?php
echo "<p>Deleting Character with CharacterId: {$character['CharacterName']}<p/>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>
</body>
</html>	