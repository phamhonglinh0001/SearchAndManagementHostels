<?php
class ChuTro extends Database
{
    public function capNhatTen($ten, $ma)
    {
        $sql = "update chu_tro set
                ten_ct='$ten'
                where ma_ct='$ma'";
        $this->query($sql);
    }

    public function layDsNt($ma_ct){
        $data = $this->query(
            "select * from nha_tro where ma_ct='$ma_ct'"
        );
        if(count($data)>0) return $data;
        else return false;
    }
    public function laySoPhong($ma_nt){
        $data = $this->query(
            "select * from phong_tro where ma_nt='$ma_nt'"
        );
        if(count($data)>0) return $data;
        else return false;
    }
    public function layTTChuTro($ma_ct){
        $sql = "select * from chu_tro
                join tai_khoan on chu_tro.ma_tk = tai_khoan.ma_tk
                join thong_tin_cn on thong_tin_cn.ma_ttcn = tai_khoan.ma_ttcn
                where ma_ct='$ma_ct'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0];
        else return false;
    }
    public function KtCoKhach($ma_nt){
        $sql = "select * from nha_tro
                join phong_tro on phong_tro.ma_nt = nha_tro.ma_nt 
                left join khach_tro on khach_tro.ma_pt = phong_tro.ma_pt
                where nha_tro.ma_nt='$ma_nt' and not(khach_tro.ma_pt IS NULL)";
        $data = $this->query($sql);
        if (count($data) > 0) return true;
        else return false;
    }
}
?>