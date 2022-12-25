<?php
    include("autoload.php");
    header('Content-Type: application/json; charset=utf-8');
    $ma_nt = $_GET["ma_nt"];
    $max = $_GET["max"];

    $data = (new TinNhan)->layTinNhan($ma_nt, $max);

    if($data) echo json_encode($data);

    else echo json_encode(array("errors"=>true));
?>