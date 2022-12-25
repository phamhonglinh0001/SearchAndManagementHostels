<?php
include("autoload.php");
$ma_pt = $_GET["ma_pt"];
$ngay_kt = $_GET["ngay_kt"];
(new PhongTro)->thanhToan($ma_pt, $ngay_kt);
?>