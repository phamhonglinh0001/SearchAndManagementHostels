<?php
    class TinNhan extends Database {
        
        public function layTinNhan($ma_nt, $max_ma_tn){
            $data = $this->query("
                select 
                tin_nhan.ma_tn, tin_nhan.noi_dung_tn, tin_nhan.ma_nt, tin_nhan.ma_kt, khach_tro.ten_kt, 
                tai_khoan.anh_dai_dien, nha_tro.ten_nt, tin_nhan.moc_thoi_gian_nhan, thong_tin_cn.gioi_tinh
                from tin_nhan
                left join khach_tro on khach_tro.ma_kt = tin_nhan.ma_kt 
                left join tai_khoan on tai_khoan.ma_tk = khach_tro.ma_tk 
                left join nha_tro on nha_tro.ma_nt = tin_nhan.ma_nt
                left join thong_tin_cn on thong_tin_cn.ma_ttcn = tai_khoan.ma_ttcn 
                where tin_nhan.ma_nt = '$ma_nt' and tin_nhan.ma_tn>'$max_ma_tn'
            ");
            if(count($data)>0) return $data;
            else return false;
        }

        public function themTinNhan($ma_nt, $ma_kt, $nd){
            $this->query("
                insert into tin_nhan
                values(NULL,'$nd',NOW(),'$ma_nt','$ma_kt')
            ");
        }
        public function themTinNhanCT($ma_nt, $nd){
            $this->query("
                insert into tin_nhan
                values(NULL,'$nd',NOW(),'$ma_nt',NULL)
            ");
        }
    }
?>