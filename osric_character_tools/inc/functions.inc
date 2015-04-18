<?php
/*function getTableSchema($databaseConnection,$databaseName,$tableName)
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
}*/

function html_listbox($name, $options, $selected_value)
{
    echo "<select name='$name'>";
	foreach($options as $val=>$label)
	{
		echo "<option value='{$val}'";
		if($val == $selected_value)
		{
			echo "selected";
		}
		echo ">{$label}</option>";
	}
	echo "</select>";
}
?>