<?php
include("autoload.php");
$ma_pt=$_GET["ma_pt"];
$data = (new PhongTro)->layTTHoaDon($ma_pt);
header('Content-Type: application/json; charset=utf-8');
if($data) echo json_encode($data);
else {
    $data = (new PhongTro)->layGiaDienNuoc($ma_pt);
    if($data)
    echo json_encode($data);
    else echo json_encode(array("status"=>"Rỗng"));
}
?>