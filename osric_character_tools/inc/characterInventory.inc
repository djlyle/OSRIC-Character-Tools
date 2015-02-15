<?php
function getTotalItemEncumbrance($cxn, $characterId)
{
	$query = "SELECT SUM(e.TotalItemEncumbrance) AS TotalEncumbrance FROM (SELECT (i.ItemEncumbrance * ci.Quantity) AS TotalItemEncumbrance FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = '{$characterId}') AS e";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute getTotalEncumbrance query.");
	$row = mysqli_fetch_assoc($result);
	return $row['TotalEncumbrance'];
}

function getTotalCoinEncumbrance($cxn, $characterId)
{
    $query = "SELECT SUM(e.TotalCoinEncumbrance) AS TotalEncumbrance FROM (SELECT (c.CoinEncumbranceInLbs * cc.Quantity) AS TotalCoinEncumbrance FROM character_coins cc INNER JOIN coins c ON cc.CoinId = c.CoinId WHERE cc.CharacterId = '{$characterId}') AS e"; 
    $result = mysqli_query($cxn,$query) or die("Couldn't execute getTotalCoinEncumbrance.");
    $row = mysqli_fetch_assoc($result);
    return $row['TotalEncumbrance'];
}

function getTotalCost($cxn, $characterId)
{
	$query = "SELECT SUM(e.TotalItemCost) AS TotalCost FROM (SELECT (ci.Quantity * i.ItemCost) AS TotalItemCost FROM character_items ci INNER JOIN items i ON ci.ItemId = i.ItemId WHERE ci.CharacterId = '{$characterId}') AS e";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute getTotalCost query.");
	$row = mysqli_fetch_assoc($result);
	return $row['TotalCost'];
}

function updateCharacterItems($cxn, $characterId, $itemId, $itemQuantity)
{
	$query = "UPDATE character_items SET Quantity = '{$itemQuantity}' WHERE character_items.CharacterId = {$characterId} AND character_items.ItemId = {$itemId}";
	$result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterItems query.");
	return $result;
}

function updateCharacterCoins($cxn, $characterId, $coinId, $coinQuantity)
{
    $query = "UPDATE character_coins SET Quantity = '{$coinQuantity}' WHERE character_coins.CharacterId = {$characterId} AND character_coins.CoinID = {$coinId}";
    $result = mysqli_query($cxn,$query) or die("Couldn't execute updateCharacterCoins query.");
    return $result; 
}

?>