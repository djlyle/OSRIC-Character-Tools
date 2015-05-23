<?php

function osricdb_getItemStatusOptions($cxn)
{
    $query = "SELECT * FROM item_status";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getItemStatusOptions query.");
    $options = array();
    while($row = mysqli_fetch_assoc($result))
    {
        $options[$row['ItemStatusId']] = $row['ItemStatus'];
    }
    return $options;
}


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