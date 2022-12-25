<?php
    header('Content-Type: application/json; charset=utf-8');
    include("../autoload.php");
    $ma_pt = $_GET["ma_pt"];
    $ma_kt = $_GET["ma_kt"];

    $data = (new PhongTroLuu)->themLuu($ma_kt, $ma_pt);

    if($data) echo json_encode(array("status"=>"success"));
    else echo json_encode(array("status"=>"error"));
?>