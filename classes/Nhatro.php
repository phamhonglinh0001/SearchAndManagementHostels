<?php
    class NhaTro extends Database{
        public function themNhaTro($ten_nt, $ngay_lap, $mo_ta, $noi_quy_nt, $ma_ct, $ma_dc){
            $sql = "insert into nha_tro(ten_nt, ngay_lap, mo_ta, noi_quy_nt, ma_ct, ma_dc, trang_thai_nt)
                    values('$ten_nt','$ngay_lap','$mo_ta','$noi_quy_nt','$ma_ct','$ma_dc','hoatdong')";
            $this->query($sql);
        }
        public function capNhatNhaTro($ma_nt, $ten_nt, $ngay_lap, $mo_ta, $noi_quy_nt){
            $sql = "update nha_tro
                    set ten_nt='$ten_nt', ngay_lap='$ngay_lap', mo_ta='$mo_ta', noi_quy_nt='$noi_quy_nt'
                    where ma_nt='$ma_nt'   
                ";
            $this->query($sql);
        }
        public function tamNgungNhaTro($ma_nt){
            $sql = "update nha_tro set
                    trang_thai_nt = 'tamngung'
                    where ma_nt='$ma_nt'   
                ";
            $this->query($sql);
            $sql = "update phong_tro set
                    trang_thai_pt = 'tamngung'
                    where ma_nt='$ma_nt'   
                ";
            $this->query($sql);
            $pt = (new NhaTro)->layDsSoPhongTro($ma_nt);
            if($pt) foreach($pt as $x){
                $ma_pt = $x["ma_pt"];
                $this->query("update khach_tro set ma_pt=NULL where ma_pt='$ma_pt'");
                $this->query("delete from yeu_cau_tham_gia where ma_pt='$ma_pt'");
            }
        }
        public function moLaiNhaTro($ma_nt){
            $sql = "update nha_tro set
                    trang_thai_nt = 'hoatdong'
                    where ma_nt='$ma_nt'   
                ";
            $this->query($sql);
            $sql = "update phong_tro set
                    trang_thai_pt = 'trong'
                    where ma_nt='$ma_nt'   
                ";
            $this->query($sql);
        }

    public function layNhaTro($ma_nt)
    {
        $sql = "select * from nha_tro
                where ma_nt='$ma_nt'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0];
        else return false;
    }
    public function layTenNhaTro($ma_nt)
    {
        $sql = "select ten_nt from nha_tro
                where ma_nt='$ma_nt'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0]["ten_nt"];
        else return false;
    }
    public function layDsNhaTro($ma_ct){
        $sql = "select * from nha_tro
                where ma_ct='$ma_ct'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data;
        else return false;
    }
    public function layDsSoPhongTro($ma_nt){
        $sql = "select * from phong_tro
                where ma_nt='$ma_nt' and trang_thai_pt='conguoi'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data;
        else return false;
    }
}
