<?php
include_once("./misc.inc");

class OsricDb
{
  
  protected $cxn;
  public function doInit($aHost,$aUser,$aPasswd)
  {
  	 $aDbname = "osric_db";
  	 $this->cxn = mysqli_connect($aHost,$aUser,$aPasswd,$aDbname) or die("Couldn't connect to server");
  }

  public function getCharacter($characterId)
  {
	if($characterId == -1)
	{
		$row['CharacterName'] = "Dummy";
		$row['CharacterGender'] = "1";
		$row['CharacterAge'] = "42";
		$row['CharacterHeight'] = "65";
	}
	else
	{
		$query = sprintf("SELECT * FROM characters WHERE CharacterId='%s'",$characterId);
		$result = mysqli_query($this->cxn,$query) or die("Couldn't execute query.");
		$row = mysqli_fetch_assoc($result);
	}
	return $row; 
  }

}

?>