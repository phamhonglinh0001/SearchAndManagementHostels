<?php
include("autoload.php");
$ma_kt = $_GET["ma_kt"];
$ma_pt = $_GET["ma_pt"];
(new PhongTro)->trucXuat($ma_kt, $ma_pt);
?>