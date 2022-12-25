<?php
include("autoload.php");
session_start();
$cn = $_GET["cn"];
if($cn=="roitro"){
    $ma_pt = $_GET["ma_pt"];
    $ma_kt = $_GET["ma_kt"];

    (new PhongTro)->roiTro($ma_kt);

    if(!(new PhongTro)->conNguoiOtro($ma_pt)){
        (new PhongTro)->trongTro($ma_pt);
    }

    header("location:chitietphongtro.php?ma_pt=$ma_pt");
}
if($cn=="YCTG"){
    $ma_pt = $_GET["ma_pt"];
    $ma_kt = $_GET["ma_kt"];

    (new YeuCauThamGia)->themYCTG($ma_kt, $ma_pt);

    header("location:chitietphongtro.php?ma_pt=$ma_pt");
}

if($cn=="huyYCTG"){
    $ma_pt = $_GET["ma_pt"];
    $ma_kt = $_GET["ma_kt"];
    
    (new YeuCauThamGia)->huyYCTG($ma_kt, $ma_pt);
    if (isset($_GET["dh"])) { if ($_GET["dh"] == "yeucau")
        header("location: yeucauthamgia.php");
    }else
    header("location:chitietphongtro.php?ma_pt=$ma_pt");
}
if($cn=="luu"){
    $ma_pt = $_GET["ma_pt"];
    $ma_kt = $_GET["ma_kt"];

    (new PhongTroLuu)->themLuu($ma_kt, $ma_pt);

    header("location:chitietphongtro.php?ma_pt=$ma_pt");
}

if($cn=="huyluu"){
    $ma_pt = $_GET["ma_pt"];
    $ma_kt = $_GET["ma_kt"];

    (new PhongTroLuu)->huyLuu($ma_kt, $ma_pt);

    header("location:chitietphongtro.php?ma_pt=$ma_pt");
}

?>