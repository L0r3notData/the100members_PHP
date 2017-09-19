<?php


$siteRoot = $_SERVER['DOCUMENT_ROOT'];


// ##### READ MEMBER LIST FROM FILE (IN A BUFFER) #####
ob_start();		
$userList = file_get_contents("$siteRoot/the100/cache/memberList.htm");
ob_end_clean();

// ##### PUT MEMBERS IN ARRAY #####
$delimList = explode("<br>", $userList);

// ##### GET FIRST LINE OF ARRAY (UNIX TIME) #####
$unixTime = $delimList[0];
//echo "$unixTime<br><br>";

// ##### SET TIME TO US PACIFIC, CONVERT UNIX CACHE TIME TO STANDARD DATE/TIME  #####
date_default_timezone_set('America/Los_Angeles');
echo '<b>As of ';
echo date('Y-m-d H:i', $unixTime);
echo ' PT</b><br>';

// ##### REMOVE FIRST LINE OF ARRAY NAD PRINT MEMBER LIST #####
array_shift($delimList);
echo implode("<br>", $delimList);


?>



