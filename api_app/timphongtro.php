<?php
    header('Content-Type: application/json;charset="utf-8"');
    include("../autoload.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);

        if($data) {
            if (isset(($data["phong2"]))){ if ($data["phong2"]) $gia_tren = $data["phong2"];
            else $gia_tren = NULL;}
            else $gia_tren = NULL;
            if (isset(($data["phong1"]))){ if ($data["phong1"]) $gia_duoi = $data["phong1"];
            else $gia_duoi = NULL;}
            else $gia_duoi = NULL;
            if (isset(($data["dien2"]))){ if ($data["dien2"]) $dien_tren = $data["dien2"];
            else $dien_tren = NULL;}
            else $dien_tren = NULL;
            if (isset(($data["dien1"]))){ if ($data["dien1"]) $dien_duoi = $data["dien1"];
            else $dien_duoi = NULL;}
            else $dien_duoi = NULL;
            if (isset(($data["nuoc2"]))){ if ($data["nuoc2"]) $nuoc_tren = $data["nuoc2"];
            else $nuoc_tren = NULL;}
            else $nuoc_tren = NULL;
            if (isset(($data["nuoc1"]))){ if ($data["nuoc1"]) $nuoc_duoi = $data["nuoc1"];
            else $nuoc_duoi = NULL;}
            else $nuoc_duoi = NULL;
            if (isset(($data["dt2"]))){ if ($data["dt2"]) $dientich_tren = $data["dt2"];
            else $dientich_tren = NULL;}
            else $dientich_tren = NULL;
            if (isset(($data["dt1"]))){ if ($data["dt1"]) $dientich_duoi = $data["dt1"];
            else $dientich_duoi = NULL;}
            else $dientich_duoi = NULL;
            if (isset(($data["nguoi2"]))){ if ($data["nguoi2"]) $songuoi_tren = $data["nguoi2"];
            else $songuoi_tren = NULL;}
            else $songuoi_tren = NULL;
            if (isset(($data["nguoi1"]))){ if ($data["nguoi1"]) $songuoi_duoi = $data["nguoi1"];
            else $songuoi_duoi = NULL;}
            else $songuoi_duoi = NULL;
            if (isset(($data["diem2"]))){ if ($data["diem2"]) $diem_tren = $data["diem2"];
            else $diem_tren = NULL;}
            else $diem_tren = NULL;
            if (isset(($data["diem1"]))){ if ($data["diem1"]) $diem_duoi = $data["diem1"];
            else $diem_duoi = NULL;}
            else $diem_duoi = NULL;
            if (isset(($data["gac"]))){ if ($data["gac"]=="co") $gac = "co";
            else $gac = "khong";}
            else $gac = "khong";
            if (isset(($data["tenTinh"]))){ if ($data["tenTinh"]) $tinh = $data["tenTinh"];
            else $tinh = NULL;}
            else $tinh = NULL;
            if (isset(($data["tenHuyen"]))){ if ($data["tenHuyen"]) $huyen= $data["tenHuyen"];
            else $huyen = NULL;}
            else $huyen = NULL;
            if (isset(($data["tenXa"]))){ if ($data["tenXa"]) $xa = $data["tenXa"];
            else $xa = NULL;}
            else $xa = NULL;

            $kq = (new PhongTro)->timKiem(
                "",
                $tinh,
                $huyen,
                $xa,
                $gia_duoi,
                $gia_tren,
                $dien_duoi,
                $dien_tren,
                $nuoc_duoi,
                $nuoc_tren,
                $dientich_duoi,
                $dientich_tren,
                $songuoi_duoi,
                $songuoi_tren,
                $diem_duoi,
                $diem_tren,
                $gac
            );
            if($kq) echo json_encode($kq);
            else echo json_encode(array("status"=>"error"));
        }
            
    }
    
?>