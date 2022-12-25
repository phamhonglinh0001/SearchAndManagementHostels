<?php
    class PhuPhi extends Database {
        
        public function themPP($ma_ctot, $ten, $gia, $gc){
            $sql = "insert into phu_phi
                    values(NULL,'$ten','$gc','$gia','$ma_ctot')";
            $this->query($sql);
        }

        public function layPP($ma_ctot){
            $data = $this->query("
                select * from phu_phi where ma_ctot='$ma_ctot'
            ");
            if(count($data)>0) return $data;
            else return false;
        }
    }
?>