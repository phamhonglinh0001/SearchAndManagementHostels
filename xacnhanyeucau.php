<?php
include("autoload.php");
session_start();

$ma_kt = $_GET["ma_kt"];
$ma_pt = $_GET["ma_pt"];

$songuoi = (new KhachTro)->soNguoiTrongTro($ma_pt);
$songuoitoida = (new PhongTro)->layMotPhongTro($ma_pt)["so_nguoi_toi_da"];

if($songuoi <= $songuoitoida - 1){
    (new KhachTro)->vaoTro($ma_kt, $ma_pt);
    (new YeuCauThamGia)->huyYCTG($ma_kt, $ma_pt);
    if(!$songuoi) (new PhongTro)->setCoNguoiPT($ma_pt);
    header("location: yeucauthamgia.php");
}else{
    $_SESSION["err"] = "Phòng trọ đã đủ người";
    header("location: yeucauthamgia.php");
}


?>