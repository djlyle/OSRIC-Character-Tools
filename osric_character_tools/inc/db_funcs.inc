<?php

function osricdb_getRaceOptions($cxn)
{
    $query = "SELECT * FROM races";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getRaceOptions query.");
    $options = array();    
    while($row = mysqli_fetch_assoc($result))
    {
        $options[$row['RaceId']] = $row['RaceName'];
    }
    return $options;
}

?>