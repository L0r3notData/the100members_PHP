<?php


// ##########################################
// ###                                    ###
// ###  GROUP MEMBERS FROM THE100.IO API  ###
// ###  v1.4                              ###
// ###  @L0r3notData                      ###
// ###                                    ###
// ##########################################


// ##### CAPTURE VIRTUAL SERVERS DOCUMENT ROOT #####
$siteRoot = $_SERVER['DOCUMENT_ROOT'];


// ##### READ API KEY AND GROUP NUMBER FROM FILE ####
require 'apiKeys.php';


// ##### PRE-SET SOME STRINGS #####
$pageCnt = 0;
$continue = 1;
$cntMembers = 0;
$memList = '';


// ##### BEGIN LOOPING THOUGH ALL MEMBER PAGES #####
while($continue == '1') {

	// ##### INCREMENT CURRENT PAGE UP #####
	$pageCnt++;

	// ##### CURL A MEMBER PAGE FROM THE100.IO IN JSON FORMAT (IN A BUFFER) #####
	ob_start();
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "http://www.the100.io/api/v1/groups/$hundGroup/users?page=$pageCnt");
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json',"Authorization: $authKey100"));
	$allUsers = curl_exec($curl);
	curl_close($curl);
	$userList = ob_get_contents();
	ob_end_clean();

	// ##### GET COUNT OF MEMBERS ON PAGE  #####
	$getUsers = json_decode($userList,true);
	$cntUser = 0;
	$cntUser = count($getUsers);
	$cntMembers = $cntMembers + $cntUser;

	// ##### SET LOOP TO STOP IF NO MEMBERS ON PAGE #####
	if ($cntUser == 0) {
		$continue = 0;
	}

	##### GET EACH MEMBERS GAMERTAG FROM PAGE #####
	$x = 0;
	while($x < $cntUser) {
		$userTag = $getUsers[$x]['gamertag'];
		$x++;
		$memList = "$memList $userTag<br>";
	}

}


// ##### EXPLODE LIST INTO ARRAY, SORT, IMPLODE BACK TO STRING #####
$memList = explode("<br>", $memList);
sort($memList, SORT_NATURAL | SORT_FLAG_CASE);
$finalMembList = implode("<br> ", $memList);


// ##### BUILD INFO STRINGS #####
$titleURL = '<a href="https://www.the100.io/groups/1412">The100</a><br>';
$titleCount = "Members: $cntMembers<br>";


// ##### WRITE MEMBER LIST TO FILE #####
$theNow = time();
$theNowTwo = "$theNow<br>";
$myFile = "$siteRoot/members/the100/cache/memberList.htm";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $theNowTwo);
fwrite($fh, $titleURL);
fwrite($fh, $titleCount);
fwrite($fh, $finalMembList);
fclose($fh);


// ##### PRINT TO WEB PAGE BY READING CACHE FILE #####
require "$siteRoot/members/the100/cache100members.php";


?>



