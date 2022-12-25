<?php
    class PhongTroLuu extends Database {
        public function kiemPhongTroLuu($ma_kt, $ma_pt){
            $data = $this->query("select * from phong_tro_luu where ma_kt='$ma_kt' and ma_pt='$ma_pt'");
            if(count($data)>0) return true;
            else return false;
        }
        public function danhSach($ma_kt){
            $sql = "select *, phong_tro.ma_pt as ma_phong from phong_tro_luu
                    left join phong_tro on phong_tro.ma_pt=phong_tro_luu.ma_pt
                    left join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt
                    left join dia_chi on dia_chi.ma_dc = nha_tro.ma_dc 
                    left join anh_pt on anh_pt.ma_pt = phong_tro.ma_pt
                    where phong_tro_luu.ma_kt='$ma_kt' group by phong_tro_luu.ma_pt";

            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function themLuu($ma_kt, $ma_pt){
            $this->query("insert into phong_tro_luu values(NULL, '$ma_kt', '$ma_pt')");
        }
        public function huyLuu($ma_kt, $ma_pt){
            $this->query("delete from phong_tro_luu where ma_kt='$ma_kt' and ma_pt='$ma_pt'");
        }
        public function layLuu($ma_kt){
            $data = $this->query("select ma_pt from phong_tro_luu where ma_kt='$ma_kt'");
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
    }

?>