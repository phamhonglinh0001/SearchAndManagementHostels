<?php
    class DiaChi extends Database {
        public function capNhat($x, $h, $t, $ma, $vi_do = NULL, $kinh_do = NULL){
            $sql = "update dia_chi set
                xa='$x', huyen='$h', tinh='$t', vi_do='$vi_do', kinh_do='$kinh_do'
                where ma_dc='$ma'";
            $this->query($sql);
        }

        public function themDiaChi($xa, $huyen, $tinh, $vi_do = NULL, $kinh_do = NULL){
            $sql = "insert into dia_chi(xa, huyen, tinh, vi_do, kinh_do)
                    values('$xa','$huyen','$tinh','$vi_do','$kinh_do')";
            $this->query($sql);
            $sql = "select max(ma_dc) from dia_chi";
            $data = $this->query($sql);
            return $data[0]["max(ma_dc)"];
        }

        public function layDiaChi($ma_dc)
    {
        $sql = "select * from dia_chi
                where ma_dc='$ma_dc'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0];
        else return false;
    }
    }
?>