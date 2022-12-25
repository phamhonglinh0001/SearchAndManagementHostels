<?php
    class YeuCauThamGia extends Database {
        public function kiemYCTG($ma_kt, $ma_pt){
            $data = $this->query("select * from yeu_cau_tham_gia where ma_kt='$ma_kt' and ma_pt='$ma_pt'");
            if(count($data)>0) return true;
            else return false;
        }
        public function themYCTG($ma_kt, $ma_pt){
            $this->query("insert into yeu_cau_tham_gia values(NULL, '$ma_kt', '$ma_pt')");
        }
        public function huyYCTG($ma_kt, $ma_pt){
            $this->query("delete from yeu_cau_tham_gia where ma_kt='$ma_kt' and ma_pt='$ma_pt'");
        }
        public function layYCTG($ma_kt){
            $data = $this->query("select ma_pt from yeu_cau_tham_gia where ma_kt='$ma_kt'");
            if(count($data)>0) return $data;
            else return false;
        }
        public function layPhongTro($ma_pt){
            $data = $this->query("select * from phong_tro
            join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt
            where phong_tro.ma_pt='$ma_pt' and not(trang_thai_pt='tamngung')");

            if(count($data)>0) return $data[0];
            else return false;
        }
        public function layYCTG_CT($ma_ct){
            $data = $this->query("
            select * from yeu_cau_tham_gia
            left join phong_tro on phong_tro.ma_pt = yeu_cau_tham_gia.ma_pt 
            left join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt 
            left join chu_tro on chu_tro.ma_ct = nha_tro.ma_ct
            where chu_tro.ma_ct='$ma_ct'");

            if(count($data)>0) return $data;
            else return false;
        }
        
    }

?>