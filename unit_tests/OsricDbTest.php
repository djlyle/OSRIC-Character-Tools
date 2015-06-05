<?php
require_once(dirname(__FILE__).'/../osric_character_tools/inc/misc.inc');
require_once(dirname(__FILE__).'/../osric_character_tools/inc/OsricDb.php');
class OsricDbTest extends PHPUnit_Framework_TestCase
{
	private $myOsricDb;
	private $myNewCharacterId;

	public function setUp()
	{
		//remember that variable references in functions are given local scope unless global is explicitly specified
		global $host,$user,$passwd;    		
		$this->myOsricDb = new OsricDb();
		$this->myOsricDb->doInit($host,$user,$passwd);
		$this->myNewCharacterId = $this->myOsricDb->createCharacter();			
	}
	
	public function tearDown()
	{
		//If the character with myNewCharacterId is still present in the database then delete it
		$newCharacter = $this->myOsricDb->getCharacter($this->myNewCharacterId);
		if($newCharacter != null)
		{
			$this->myOsricDb->deleteCharacter($this->myNewCharacterId);
		}
	}
    
	public function testCreateDefaultCharacter()
	{
		$newCharacter = $this->myOsricDb->getCharacter($this->myNewCharacterId);
		
		$this->assertEquals("Mr. Generic",$newCharacter['CharacterName'],'Name should be: Mr. Generic');
		$this->assertEquals(42,$newCharacter['CharacterAge'],'Age should be: 42');
		$this->assertEquals(1,$newCharacter['CharacterGender'],'Gender should be: 1 (Male)');
		$this->assertEquals(140,$newCharacter['CharacterWeight'],'Weight should be: 140');
		$this->assertEquals(65,$newCharacter['CharacterHeight'],'Height should be: 65');    
		$this->assertEquals(0,$newCharacter['RaceId'],'RaceId should be: 0 (Human)');         
	}
	
	public function editCharacterDataProvider()
	{
		return array(
			array("Mr. Test1",20,1,130,60,1),
			array("Mr. Test2",40,1,135,59,1),
			array("Mrs. Test3",50,2,150,55,2),
			array("Mr. Test4",99,1,140,58,0)
		);	
	}
	
	/**
	 * @dataProvider editCharacterDataProvider
	 */
	 public function testEditCharacter($name,$age,$gender,$weight,$height,$raceId)
	 {
	 	$character = array();
	 	$character['CharacterName'] = $name;
	 	$character['CharacterAge'] = $age;
	 	$character['CharacterGender'] = $gender;
	 	$character['CharacterWeight'] = $weight;
	 	$character['CharacterHeight'] = $height;
	 	$character['RaceId'] = $raceId;
	 	$character['CharacterId'] = $this->myNewCharacterId;
	 	$character['CharacterAlignment'] = 0;
		$this->myOsricDb->editCharacter($this->myNewCharacterId,$name,$age,$gender,$weight,$height,$raceId);
		$editedCharacter = $this->myOsricDb->getCharacter($this->myNewCharacterId);
		$this->assertEquals($character,$editedCharacter);	 	
	 }
	
	/**
	 * @depends testCreateDefaultCharacter	
	 */
	public function testDeleteDefaultCharacter($newCharacterId)
	{
		$this->myOsricDb->deleteCharacter($newCharacterId);
		$character = $this->myOsricDb->getCharacter($newCharacterId);	
		$this->assertEquals(null,$character);	
	}
}

?>