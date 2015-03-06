<?php
include("./inc/misc.inc");
include("./inc/charactertblfuncs.inc");
$characterId = $_POST['CharacterId'];
/*If the cancel button was pressed in the form from editcharacterstatus.php
  then return to characters.php */
if(@$_POST['cancelbutton'] == "Cancel")
{
	header("Location: characters.php");
}
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Couldn't connect to server");

editCharacterStatus($cxn,$_POST);

echo "<p>Character status updated.</p>";
echo "<a href='characters.php'>Return to list of characters</a>";
?>