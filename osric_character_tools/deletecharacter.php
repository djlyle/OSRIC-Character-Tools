<?php
/*Program: deletecharacter.php
   Desc: Deletes an existing character in the Characters table and related tables in the osric_db*/

$CharacterId = $_GET['CharacterId'];
echo "Deleting Character with CharacterId={$CharacterId}";

include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");

$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

if($CharacterId != -1)
{
	$character = getCharacter($cxn,$CharacterId);
	deleteCharacter($cxn,$CharacterId);
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