<?php
require "config.php";

foreach($server as $key => $value) {

    $ctime = file_get_contents($value);
    if(abs($ctime - time()) < 3)
        $is_up = 1;
    else
        $is_up = 0;

    mysqli_query($dblink, "INSERT INTO `{$key}` (`time`, `status`) VALUES (".time().", '{$is_up}'); ");

    // Cleanup DB
    mysqli_query($dblink, "DELETE FROM `{$key}` WHERE `time` < ".(time() - ($days_history * 86400))." ");

}
