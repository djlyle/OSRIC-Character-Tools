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
include("/inc/misc.inc");
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");
$query = "SELECT * from characters";
$result = mysqli_query($cxn,$query) or die("Couldn't execute query.");
$genderArray = array("Unknown","Male","Female");
?>
<h3>Characters</h3>
<?php
/*Display results in table*/
echo "<table id='osric_characters'>";
echo "<tr><td>Name</td><td>Gender</td><td>Age (years)</td><td>Height (inches)</td><td>Weight (lbs)</td><td>Edit</td><td>Equip</td></tr>";
while($row = mysqli_fetch_assoc($result))
{
echo "<tr>";
echo "<td>{$row['CharacterName']}</td>";
$gender = $genderArray[$row['CharacterGender']];
echo "<td>{$gender}</td>";
echo "<td>{$row['CharacterAge']}</td>";
echo "<td>{$row['CharacterHeight']}</td>";
echo "<td>{$row['CharacterWeight']}</td>";
echo "<td><a href='editcharacter.php?CharacterId={$row['CharacterId']}'>Edit Character</a></td>";
echo "<td><a href='equipcharacter.php?CharacterId={$row['CharacterId']}'>Equip Character</td>";
echo "<td><a href='deletecharacter.php?CharacterId={$row['CharacterId']}'>Delete Character</td>";
echo "</tr>";
}
echo "</table>";
echo "<a href='editcharacter.php?CharacterId=-1'>Add New Character</a></td>";
?>
</body>
</html>