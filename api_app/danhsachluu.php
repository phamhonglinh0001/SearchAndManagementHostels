<?php
    header('Content-Type: application/json; charset=utf-8');
    include("../autoload.php");
    $ma_kt = $_GET["ma_kt"];

    $data = (new PhongTroLuu)->danhSach($ma_kt);

    if($data) echo json_encode($data);
    else echo json_encode(array("status"=>"error"));
?>