<?php
require "config.php";





$mysqlresult = mysqli_query($dblink, "SELECT * FROM `tascrafts.com` ORDER BY `time` ASC");
while($row = mysqli_fetch_assoc($mysqlresult)) {

    if($row['status']==0) {
        if(!$xtime) $xtime = $row['time'];
        $count++;
    }

    if($row['status']==1) {
        if($xtime) $result[$xtime] = $count;
        unset($count, $xtime);
    }

    if(count($result) > 5) break;

}

// Reverse the array to show the newest on the top.
$result = array_reverse($result,true);



// Today
$today_online  = mysqli_fetch_assoc(mysqli_query($dblink, "SELECT COUNT(`time`) FROM `tascrafts.com` WHERE `status` = 1 and `time` > ".(1*24*60*60)." "));
$today_offline = mysqli_fetch_assoc(mysqli_query($dblink, "SELECT COUNT(`time`) FROM `tascrafts.com` WHERE `status` = 0 and `time` > ".(1*24*60*60)." "));
$today_percent = $today_online['COUNT(`time`)'] / ($today_online['COUNT(`time`)'] + $today_offline['COUNT(`time`)']) * 100;

// This week
$week_online  = mysqli_fetch_assoc(mysqli_query($dblink, "SELECT COUNT(`time`) FROM `tascrafts.com` WHERE `status` = 1 and `time` > ".(7*24*60*60)." "));
$week_offline = mysqli_fetch_assoc(mysqli_query($dblink, "SELECT COUNT(`time`) FROM `tascrafts.com` WHERE `status` = 0 and `time` > ".(7*24*60*60)." "));
$week_percent = $week_online['COUNT(`time`)'] / ($week_online['COUNT(`time`)'] + $week_offline['COUNT(`time`)']) * 100;

// This week
$month_online  = mysqli_fetch_assoc(mysqli_query($dblink, "SELECT COUNT(`time`) FROM `tascrafts.com` WHERE `status` = 1 and `time` > ".(30*24*60*60)." "));
$month_offline = mysqli_fetch_assoc(mysqli_query($dblink, "SELECT COUNT(`time`) FROM `tascrafts.com` WHERE `status` = 0 and `time` > ".(30*24*60*60)." "));
$month_percent = $month_online['COUNT(`time`)'] / ($month_online['COUNT(`time`)'] + $month_offline['COUNT(`time`)']) * 100;






?><!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <? if($auto_refresh) { ?><meta http-equiv="refresh" content="<?=$auto_refresh;?>"><? } ?>
    <title>Iyrin Server Monitor</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>
<body>
<div class="container">





<div class="row">
    <div class="col-sm">
        <h1>Iyrin Server Monitor</h1>
        <span class="text-muted">Version 0.01</span><br><br><br><br>
    </div>
</div>





<div class="row">
    <div class="col-md-5">
        <h3>Uptime Graphs</h3>
        Today
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: <?=round($today_percent,4);?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$today_percent;?>%</div>
        </div>
        <br>

        Last 7 days
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: <?=round($week_percent,4);?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$week_percent;?>%</div>
        </div>
        <br>

        Last 30 days
        <div class="progress">
          <div class="progress-bar" role="progressbar" style="width: <?=round($month_percent,4);?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$month_percent;?>%</div>
        </div>
        <br>
    </div>

    <div class="col-md-1"></div>

    <div class="col-md-6">
        <h3>Latest incidents</h3>
        <? foreach($result as $key => $value) { ?>
            <p>Server went down at <?=date("F j, Y, g:ia", $key);?> for <?=$value;?> minutes.</p>
        <? } ?>
    </div>
</div>










</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>