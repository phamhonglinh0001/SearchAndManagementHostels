<?php
    class DanhGia extends Database {
        
        public function layDsDanhGia($ma_nt){
            $sql = "select * from danh_gia
                    where ma_nt='$ma_nt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function themDanhGia($diem, $ma_nt, $ma_kt){
            $sql = "insert into danh_gia
                    values(NULL,'$diem','$ma_nt', '$ma_kt')";
            $this->query($sql);

            $sql = "select * from danh_gia
                    where ma_nt='$ma_nt'";
            $data = $this->query($sql);
            $tong = 0;
            if(!$data) $this->query("update nha_tro set diem_dg = '$diem' where ma_nt='$ma_nt'");
            else{
                foreach($data as $x){
                    $tong+=$x["diem_dg"];
                }
                $diemtb = round($tong/count($data), 1);
                $this->query("update nha_tro set diem_dg = '$diemtb' where ma_nt='$ma_nt'");
            }

        }
        public function kiemTraDG($ma_kt, $ma_nt){
            $data = $this->query("select * from danh_gia where ma_nt='$ma_nt' and ma_kt='$ma_kt'");
            if(count($data)>0) return false;
            else {
                $data = $this->query("select * from chi_tiet_o_tro 
                join phong_tro on phong_tro.ma_pt = chi_tiet_o_tro.ma_pt 
                join nha_tro on phong_tro.ma_nt = nha_tro.ma_nt
                where nha_tro.ma_nt='$ma_nt' and chi_tiet_o_tro.ma_kt='$ma_kt'");
                if(count($data)>0) return true;
                else return false;
            }
        }

    }
?>