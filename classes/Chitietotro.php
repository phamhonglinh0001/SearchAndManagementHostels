<?php
    class ChiTietOTro extends Database {

        

        public function layNam($ma_nt){
            $data = $this->query("
            SELECT DISTINCT YEAR(ngay_ket_thuc) as year FROM `chi_tiet_o_tro`
                LEFT JOIN phong_tro on phong_tro.ma_pt=chi_tiet_o_tro.ma_pt
                LEFT JOIN nha_tro on nha_tro.ma_nt=phong_tro.ma_nt
            WHERE nha_tro.ma_nt='$ma_nt' order by year desc
            ");
            if(count($data)>0) return $data;
            else return false;
        }

        public function thongKeAll($ma_nt, $nam){
            $data = $this->query("
            SELECT *, MONTH(ngay_ket_thuc) as thang FROM `chi_tiet_o_tro`
                LEFT JOIN phong_tro on phong_tro.ma_pt=chi_tiet_o_tro.ma_pt
                LEFT JOIN nha_tro on nha_tro.ma_nt=phong_tro.ma_nt
            WHERE nha_tro.ma_nt='$ma_nt' and YEAR(ngay_ket_thuc)='$nam' group by chi_tiet_o_tro.ngay_ket_thuc, chi_tiet_o_tro.ma_pt order by thang asc
            ");
            if(count($data)>0) return $data;
            else return false;
        }
        
        public function layChiTiet($ma_kt, $ma_pt){
            $data = $this->query("
            select * from chi_tiet_o_tro
            left join phong_tro on chi_tiet_o_tro.ma_pt = phong_tro.ma_pt 
            left join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt 
            where chi_tiet_o_tro.ma_kt = '$ma_kt' and chi_tiet_o_tro.ma_pt='$ma_pt'
            order by chi_tiet_o_tro.ma_ctot DESC
            ");
            if(count($data)>0) return $data;
            else return false;
        }
        public function layChiTietCT($ma_pt, $ngay_bd = "", $ngay_kt = ""){
            $sql = "
            select * from chi_tiet_o_tro
            left join phong_tro on chi_tiet_o_tro.ma_pt = phong_tro.ma_pt 
            left join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt 
            where chi_tiet_o_tro.ma_pt='$ma_pt' ";
            if($ngay_bd) $sql.="and chi_tiet_o_tro.ngay_bat_dau>='$ngay_bd' ";
            if($ngay_kt) $sql.="and chi_tiet_o_tro.ngay_ket_thuc<='$ngay_kt' ";
            $sql.="group by chi_tiet_o_tro.ngay_bat_dau order by chi_tiet_o_tro.ma_ctot DESC";
            $data = $this->query($sql);
            if(count($data)>0) return $data;
            else return false;
        }

        public function layDsNt($ma_kt){
            $data = $this->query("
            select distinct nha_tro.ma_nt, nha_tro.ten_nt from chi_tiet_o_tro
            left join phong_tro on chi_tiet_o_tro.ma_pt = phong_tro.ma_pt 
            left join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt 
            where chi_tiet_o_tro.ma_kt = '$ma_kt'
            ");
            if(count($data)>0) return $data;
            else return false;
        }

        public function layDsPt($ma_nt, $ma_kt){
            $data = $this->query("
            select distinct phong_tro.so_phong, phong_tro.ma_pt from chi_tiet_o_tro
            left join phong_tro on chi_tiet_o_tro.ma_pt = phong_tro.ma_pt 
            left join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt 
            where chi_tiet_o_tro.ma_kt = '$ma_kt' and nha_tro.ma_nt = '$ma_nt'
            ");
            if(count($data)>0) return $data;
            else return false;
        }
    }
?>