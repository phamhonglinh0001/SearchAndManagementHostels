<?php
class KhachTro extends Database
{
    public function capNhat($ten, $cccd, $bsx, $ma_tk)
    {
        $sql = "update khach_tro set
                ten_kt='$ten', bien_so_xe='$bsx', so_cccd='$cccd'
                where ma_tk='$ma_tk'";
        $this->query($sql);
    }
    public function layPhongTro($ma_kt){
        $data = $this->query("
        select ma_pt from khach_tro where ma_kt='$ma_kt'
        ");
        if(count($data)>0) return $data[0]["ma_pt"];
        else return false;
    }
    public function layNhaTro($ma_kt){
        $data = $this->query("
        select nha_tro.ten_nt from khach_tro
        left join phong_tro on phong_tro.ma_pt = khach_tro.ma_pt
        left join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt
        where khach_tro.ma_kt='$ma_kt'
        ");
        if(count($data)>0) return $data[0]["ten_nt"];
        else return false;
    }
    public function layThongTinKhachTro($ma_kt){
        $data = $this->query("
        select * from khach_tro
        join tai_khoan on tai_khoan.ma_tk = khach_tro.ma_tk 
        join thong_tin_cn on thong_tin_cn.ma_ttcn = tai_khoan.ma_ttcn 
        join dia_chi on dia_chi.ma_dc = thong_tin_cn.ma_que_quan
        where khach_tro.ma_kt='$ma_kt'");

        if(count($data)>0) return $data[0];
        else return false;
    }

    public function layMaNhaTro($ma_kt){
        $data = $this->query("
            select nha_tro.ma_nt from khach_tro
            left join phong_tro on phong_tro.ma_pt=khach_tro.ma_pt 
            left join nha_tro on nha_tro.ma_nt=phong_tro.ma_nt 
            where khach_tro.ma_kt='$ma_kt'
        ");
        if(count($data)>0) return $data[0]["ma_nt"];
        else return false;
    }
    public function soNguoiTrongTro($ma_pt){
        $data = $this->query("
        select ma_kt from khach_tro where ma_pt='$ma_pt'
        ");

        if(count($data)>0) return count($data);
        else return false;
    }
    public function vaoTro($ma_kt, $ma_pt){
        $this->query("update khach_tro set ma_pt='$ma_pt' where ma_kt='$ma_kt'");

    }
}
?>