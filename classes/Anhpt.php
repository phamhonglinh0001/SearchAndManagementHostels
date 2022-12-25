<?php
    class AnhPt extends Database {
        
        public function layMaxId(){
            $sql = "select max(ma_apt) from anh_pt";
            $data = $this->query($sql);
            if (count($data) > 0) return $data[0]["max(ma_apt)"];
            else return false;
        }

        public function themAnh($ten_apt, $ma_pt){
            $sql = "insert into anh_pt(ma_pt, ten_apt)
                    values('$ma_pt','$ten_apt')";
            $this->query($sql);
        }
        public function xoaAnh($ma_apt){
            $sql = "delete from anh_pt
                    where ma_apt='$ma_apt'";
            $this->query($sql);
        }

        public function capNhat($ten_apt, $ma_apt){
            $sql = "update anh_pt set
                   ten_apt='$ten_apt'
                   where ma_apt='$ma_apt'";
            $this->query($sql);
        }

        public function layAllAnh($ma_pt){
            $sql = "select * from anh_pt where ma_pt='$ma_pt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function layTenMotAnh($ma_apt){
            $sql = "select ten_apt from anh_pt where ma_apt='$ma_apt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data[0]["ten_apt"];
            else return false;
        }

        public function layTenAnh($ma_apt){
            $sql = "select ten_apt from anh_pt where ma_apt='$ma_apt'";
            $data = $this->query($sql);
            if (count($data) > 0) return explode(".", $data[0]["ten_apt"])[0];
            else return false;
        }
    }
?>