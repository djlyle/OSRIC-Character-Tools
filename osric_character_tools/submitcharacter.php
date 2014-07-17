<?php
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
$characterId = $_POST['CharacterId'];
/*If the cancel button was pressed in the form from editcharacter.php
  then return to characters.php */
if(@$_POST['cancelbutton'] == "Cancel")
{
	header("Location: characters.php");
}
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

/*Note: function editCharacter handles both new and existing characters.  That is, if the character is brand new it inserts it as a new row
  in the database, otherwise it updates an existing row for an existing character in the database*/
editCharacter($cxn,$_POST);

echo "<p>Character updated.</p>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>