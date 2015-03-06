<?php
/*Program: characters.php
*Desc: Displays list of characters in OSRIC project
*/
?>
<html>
<head>
<title>OSRIC Project characters vs 1.0</title>
<link rel="stylesheet" type="text/css" href="./css/class.css" />
</head>
<body>
<?php
include("./inc/misc.inc");
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$query = "SELECT * from characters";
$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
$genderArray = array("Unknown","Male","Female");
?>
<h3>Characters</h3>
<?php
/*Display results in table*/
echo "<table id='osric_characters'>";
echo "<tr><td>Name</td><td>Traits</td><td>Status</td><td>Abilities</td><td>Equip</td><td>Delete</td></tr>";
while($row = mysqli_fetch_assoc($result))
{
echo "<tr>";
echo "<td>{$row['CharacterName']}</td>";
echo "<td><a href='editcharacter.php?CharacterId={$row['CharacterId']}'>Edit Character Traits</a></td>";
echo "<td><a href='editcharacterstatus.php?CharacterId={$row['CharacterId']}'>Edit Character Status</a></td>";
echo "<td><a href='editcharacterabilities.php?CharacterId={$row['CharacterId']}'>Edit Character Abilities</a></td>";
echo "<td><a href='equipcharacter.php?CharacterId={$row['CharacterId']}'>Equip Character</a></td>";
echo "<td><a href='deletecharacter.php?CharacterId={$row['CharacterId']}'>Delete Character</a></td>";
echo "</tr>";
}
echo "</table>";
echo "<a href='editcharacter.php?CharacterId=-1'>Add New Character</a></td>";
?>
</body>
</html>