<?php
    $msg = "";
    $time = date("H");
    $timezone = date("e");
    if ($time < "12") {
        $msg = "Bom dia";
    } else
    if ($time >= "12" && $time < "18") {
        $msg = "Boa Tarde";
    } else
    if ($time >= "18") {
        $msg = "Boa noite";
    } 
?>