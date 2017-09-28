<?php


// ##########################################
// ###                                    ###
// ###  GROUP MEMBERS FROM THE100.IO API  ###
// ###  v1.4                              ###
// ###  @L0r3notData                      ###
// ###                                    ###
// ##########################################


// ##### CACHE LIFETIME IN SECONDS #####
$cacheSeconds = 7200;


// ##### CAPTURE VIRTUAL SERVERS DOCUMENT ROOT #####
$siteRoot = $_SERVER['DOCUMENT_ROOT'];


// ##### GET THE CURRENT SERVER TIME IN UNIX FORMAT #####
$theNow = time();


// ##### IF CACHE FILE IS PRESENT, CHECK THE CACHE DATE #####
if (file_exists("$siteRoot/members/the100/cache/memberList.htm")) {

	// ##### GET CONTENTS OF MEMBER CACHE FILE (IN A BUFFER) #####
	ob_start();
	$cacheFile = file_get_contents("$siteRoot/members/the100/cache/memberList.htm");
	echo "$cacheFile";
	$cacheData = ob_get_contents();
	ob_end_clean();

	// ##### EXTRACT THE FIRST LINE OF THE BUFFER (CONTAINS CACHE CREATION DATE) #####
	$cacheTime = strtok($cacheData, "<br>");
	$cacheTimeTwo = preg_replace('/[^0-9.]+/', '', $cacheTime);

	// ##### CALCULATE IF CACHE IS OVER THRESHOLD AGE #####
	$timeDif = abs($theNow - $cacheTimeTwo);

	// ##### IF CACHE IS NOT OLD, GET MEMBERS FROM CACHE #####
	if ($timeDif <= $cacheSeconds) {
		 require "$siteRoot/members/the100/cache100members.php";
		// require "cache100members.php";
		// require "$siteRoot" .'/cache100members.php';
		// require "$siteRoot/cache100members.php";
		// require ("$siteRoot"."/cache100members.php");
	
	}

	// ##### IF CACHE IS OLD, GET MEMBERS FROM API AND UPDATE CACHE #####
	if ($timeDif > $cacheSeconds) {
		// chmod('cache/memberList.htm', 0777); NOT WORKING, BUT NOT REQUIRED
		require "$siteRoot/members/the100/api100members.php";
	}

}


// ##### IF THE CACHE FILE IS NOT PRESENT, GET MEMBERS FROM API AND CREATE CACHE FILE #####
if (!file_exists("$siteRoot/members/the100/cache/memberList.htm")) {
	if (!file_exists('cache')) {
		mkdir ('cache', 0777);
	}
	file_put_contents ("$siteRoot/members/the100/cache/memberList.htm", '');
	//chmod('cache/memberList.htm', 0777); NOT WORKING, BUT NOT REQUIRED
	require "$siteRoot/members/the100/api100members.php";
}



?>

