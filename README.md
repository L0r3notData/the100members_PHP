# WHAT IS THIS THING? #
Set PHP files that reads pages of users from the100.io API for a specified group
It uses caching to reduce load times (if your 100 group is large, it takes 15+ seconds)
Note: You specify the group number and put your personal group the100.io API key in apiKeys.php


# WHAT EVERYTHING DOES #

# apiKeys.php #
Contains group ID
Contains users API key

# the100members.php (primary file) #
Get the current unix time
If the cache file is present
	Gets the contents of the cache file
	Extracts the first line of the file (unix time)
	If cache is not too old, calls "cache100members.php" to read cache file and output to web page
	Set permission on empty cache dir, and empty cache file		<--- FUTURE VERSION
	If cache is too old, calls "api100members.php" to create new cache file data
If the cache file is not present
	Create the empty cache dir, and empty cache file
	Set permission on empty cache dir, and empty cache file		<--- FUTURE VERSION
	Calls "api100members.php"

# api100members.php #
Calls "apiKeys.php"
Loop though curling down each page of members from the the100.ip API
Builds a string containing all gamer tags from the member pages
Writes the unix date/time to the cache file
Writes the URL to the groups the100.io page to the cache file
Writes the string of gamertags to the file
Calls "cache100members.php" to read cache file and output to web page

# cache100members.php #
Gets the contents of the cache file (memberList.htm)
Removes the first line (unix time)
Converts the first line to standard date/time
Prints standard date/time and user list to page

# cache/memberList.htm #
This path and file are auto created
Contains:
	1st Line: Unix time cache was created
	2nd Line: 
	3rd Line:
	4th and all following files: List of members of a the100.io group


------ CHANGE LOG ------

# CHANGES 0.0 --> 1.0 #
Initial working version

# CHANGES 1.0 --> 1.1 #
Added call to cache100members.php at the end of api100members.php to fix "white screen" bug
Added auto creation of cache dir if not present
Added auto creation of cache file if not present

# CHANGES 1.1 --> 1.2 #
Added $_SERVER['DOCUMENT_ROOT']; paths for ease of embedding and moving locations

# TARGETED CHANGES 1.1 --> 1.2 #
Single variable to set cache lifetime
Added always resetting cache dir permissions to writeable
Added always resetting cache file permissions to writeable
Possible addition of "please wait" spinner when fetching members from the100.io API
