<?php
require_once(dirname(__FILE__).'/../osric_character_tools/inc/misc.inc');
require_once(dirname(__FILE__).'/../osric_character_tools/inc/OsricDb.php');
class OsricDbTest extends PHPUnit_Framework_TestCase
{
	private $myOsricDb;

	public function setUp()
	{
		//remember that variable references in functions are given local scope unless global is explicitly specified
		global $host,$user,$passwd;    		
		$this->myOsricDb = new OsricDb();
		$this->myOsricDb->doInit($host,$user,$passwd);
	}
    
	public function testCreateDefaultCharacter()
	{
		$newCharacterId = $this->myOsricDb->createCharacter();
		$newCharacter = $this->myOsricDb->getCharacter($newCharacterId);
		$this->assertEquals("Mr. Generic",$newCharacter['CharacterName'],'Name should be: Mr. Generic');
		$this->assertEquals(42,$newCharacter['CharacterAge'],'Age should be: 42');
		$this->assertEquals(1,$newCharacter['CharacterGender'],'Gender should be: 1 (Male)');
		$this->assertEquals(140,$newCharacter['CharacterWeight'],'Weight should be: 140');
		$this->assertEquals(65,$newCharacter['CharacterHeight'],'Height should be: 65');    
		$this->assertEquals(0,$newCharacter['RaceId'],'RaceId should be: 0 (Human)');         
	}
}

?>