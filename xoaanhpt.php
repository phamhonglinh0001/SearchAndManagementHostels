<?php
include("autoload.php");
$ma_apt = $_GET["ma_apt"];
unlink("./assets/img/phongtro/".(new AnhPt)->layTenMotAnh($ma_apt));
(new AnhPt)->xoaAnh($ma_apt);
?>