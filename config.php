<?php

/*
        BEGIN CONFIG HERE
*/


// How many days to keep history for
$days_history = 180;

// Enable autorefresh in minutes, 0 to disable
$auto_refresh = 1;

// A list of servers to monitor. The file only has to echo the unix timestamp.
//$server['domain.com'] = "http://domain.com/pinger.php";
$server['tascrafts.com'] = "http://tascrafts.com/pinger.php";

// Your regular mySQL connection information.
$mysql_user   = "";
$mysql_pass   = "";
$mysql_db     = "";
$mysql_server = "localhost";


/*
        END OF CONFIG
*/











/*
        DON'T MIND ANY OF THIS!
*/
$dblink = mysqli_connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
foreach($server as $key => $value) {
    mysqli_query($dblink, "
    CREATE TABLE IF NOT EXISTS `{$key}` (
      `time` int(10) NOT NULL,
      `status` int(1) NOT NULL,
      UNIQUE KEY `time` (`time`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
    ");
}
