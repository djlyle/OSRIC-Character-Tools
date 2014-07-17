<?php
function getTableSchema($databaseConnection,$databaseName,$tableName)
{
	$query = sprintf("SELECT column_name, data_type FROM information_schema.columns WHERE table_schema = \'%s\' AND table_name = \'%s\' ORDER BY ordinal_position",$databaseName,$tableName);
	$result = mysqli_query($databaseConnection,$query) or die("Couldn't execute query.");
	while($row = mysqli_fetch_assoc($result))
	{
		foreach($row as $colname => $value)
		{
			$tableSchema[$colname] = array(
		}
	}
	return $tableSchema;	
}
?>