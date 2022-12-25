<?php
    class BinhLuan extends Database {
        
        public function layDsBinhLuan($ma_nt){
            $sql = "select * from binh_luan
                    join khach_tro on binh_luan.ma_kt = khach_tro.ma_kt
                    join tai_khoan on khach_tro.ma_tk = tai_khoan.ma_tk
                    join thong_tin_cn on thong_tin_cn.ma_ttcn = tai_khoan.ma_ttcn
                    where ma_nt='$ma_nt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }

        public function layAllBinhLuan($ma_pt){
            $sql = "select * from binh_luan
                    left join khach_tro on binh_luan.ma_kt = khach_tro.ma_kt
                    left join tai_khoan on khach_tro.ma_tk = tai_khoan.ma_tk
                    left join thong_tin_cn on thong_tin_cn.ma_ttcn = tai_khoan.ma_ttcn
                    left join nha_tro on nha_tro.ma_nt=binh_luan.ma_nt 
                    left join phong_tro on phong_tro.ma_nt=nha_tro.ma_nt 
                    where phong_tro.ma_pt='$ma_pt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function themBinhLuan($nd, $ma_nt, $ma_kt){
            $sql = "insert into binh_luan
                    values(NULL,'$nd',NOW(),'$ma_nt', '$ma_kt')";
            $this->query($sql);
        }


    }
?>