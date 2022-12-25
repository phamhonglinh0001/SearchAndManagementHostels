<?php

class ThongKe extends Database{
    public function soPhong($ma_nt){
        $co_nguoi = $this->query("
            select distinct khach_tro.ma_pt from khach_tro
            left join phong_tro on phong_tro.ma_pt = khach_tro.ma_pt 
            left join nha_tro on nha_tro.ma_nt=phong_tro.ma_nt
            where nha_tro.ma_nt='$ma_nt'
        ");

        $tong_so = $this->query("
            select ma_pt from phong_tro where ma_nt='$ma_nt'
        ");

        return (array("so_phong"=>count($tong_so), "co_nguoi"=>count($co_nguoi)));

    }

    public function danhGia($ma_nt){
        $data = $this->query("
            SELECT diem_dg, COUNT(*) FROM danh_gia 
            where ma_nt='$ma_nt'
            GROUP BY diem_dg ORDER BY diem_dg DESC
        ");
        // print_r($data);
        $d1=0; $d2=0; $d3=0; $d4=0; $d5=0;
        foreach($data as $x){
            if($x["diem_dg"]==5) $d5 = $x["COUNT(*)"];
            if($x["diem_dg"]==4) $d4 = $x["COUNT(*)"];
            if($x["diem_dg"]==3) $d3 = $x["COUNT(*)"];
            if($x["diem_dg"]==2) $d2 = $x["COUNT(*)"];
            if($x["diem_dg"]==1) $d1 = $x["COUNT(*)"];
        }
        // if(isset($data[0]["diem_dg"])) $d5=$data[0]["COUNT(*)"];
        // if(isset($data[1]["diem_dg"])) $d4=$data[1]["COUNT(*)"];
        // if(isset($data[2]["diem_dg"])) $d3=$data[2]["COUNT(*)"];
        // if(isset($data[3]["diem_dg"])) $d2=$data[3]["COUNT(*)"];
        // if(isset($data[4]["diem_dg"])) $d1=$data[4]["COUNT(*)"];
        
        return (array("1"=>$d1, "2"=>$d2, "3"=>$d3, "4"=>$d4, "5"=>$d5));
    }

    public function soNguoi($ma_nt, $nam){
        $data = $this->query("
        SELECT ma_kt, MONTH(ngay_ket_thuc) as thang, count(*) as so_khach FROM `chi_tiet_o_tro`
                LEFT JOIN phong_tro on phong_tro.ma_pt=chi_tiet_o_tro.ma_pt
                LEFT JOIN nha_tro on nha_tro.ma_nt=phong_tro.ma_nt
            WHERE nha_tro.ma_nt='$ma_nt' and YEAR(ngay_ket_thuc)='$nam' group by chi_tiet_o_tro.ngay_ket_thuc order by thang asc
        ");

        return $data;
    }

    public function thongKePhong($ma_pt, $nam){
        $data = $this->query("
        SELECT *, MONTH(ngay_ket_thuc) as thang, count(*) as so_khach FROM `chi_tiet_o_tro`
            LEFT JOIN phong_tro on phong_tro.ma_pt=chi_tiet_o_tro.ma_pt
        WHERE phong_tro.ma_pt='$ma_pt' and YEAR(ngay_ket_thuc)='$nam' group by chi_tiet_o_tro.ngay_ket_thuc order by thang asc
        ");
        if(count($data)>0) return $data;
        else return false;
    }
}

?>