<?php
    header('Content-Type: text/html; charset=utf-8');
    include("autoload.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);

        $ma_nt = $data["ma_nt"];
        $noidung = $data["noidung"];

        (new TinNhan)->themTinNhanCT($ma_nt, $noidung);
    }
?>