<?php
class TaiKhoan extends Database
{
        public function kttaikhoan($u, $p){
                $sql = "select * from tai_khoan
                left join khach_tro on khach_tro.ma_tk=tai_khoan.ma_tk
                where tai_khoan.ten_dang_nhap='$u' and tai_khoan.mat_khau='$p' and tai_khoan.loai_tk='khachtro'";
                $data = $this->query($sql);
                if (count($data) > 0) return $data[0]["ma_kt"];
                else return false;
        }
    public function layMaTK($u, $p)
    {
        $sql = "select ma_tk, loai_tk from tai_khoan
                where ten_dang_nhap='$u' and mat_khau='$p'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0];
        else return false;
    }
    public function layMaTTCN($ma_tk)
    {
        $sql = "select ma_ttcn from tai_khoan
                where ma_tk='$ma_tk'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0]["ma_ttcn"];
        else return false;
    }
    public function layAVT($ma_tk)
    {
        $sql = "select anh_dai_dien from tai_khoan
                where ma_tk='$ma_tk'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0]["anh_dai_dien"];
        else return false;
    }
    public function layGT($ma_tk)
    {
        $sql = "select thong_tin_cn.gioi_tinh from tai_khoan
                join thong_tin_cn on thong_tin_cn.ma_ttcn = tai_khoan.ma_ttcn
                where tai_khoan.ma_tk='$ma_tk'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0]["gioi_tinh"];
        else return false;
    }
    public function capNhatAVT($ma_tk, $anh)
    {
        $sql = "update tai_khoan set
                anh_dai_dien='$anh'
                where ma_tk='$ma_tk'";
        
        $this->query($sql);
        
    }
    
    public function layMaCt($ma_tk) {
        $sql = "select ma_ct from chu_tro
                where ma_tk='$ma_tk'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0]["ma_ct"];
        else return false;
    }
    public function layMaKt($ma_tk) {
        $sql = "select ma_kt from khach_tro
                where ma_tk='$ma_tk'";
        $data = $this->query($sql);
        if (count($data) > 0) return $data[0]["ma_kt"];
        else return false;
    }
    public function kiemTraTonTai($u, $sdt, $email)
    {
        $sql = "select ten_dang_nhap from tai_khoan
                where ten_dang_nhap='$u'";
        $data = $this->query($sql);
        if (count($data) > 0) return "Tên đăng nhập đã tồn tại";

        $sql = "select sdt from thong_tin_cn
                where sdt='$sdt'";
        $data = $this->query($sql);
        if (count($data) > 0) return "Số điện thoại đã tồn tại";

        $sql = "select email from thong_tin_cn
                where email='$email'";
        $data = $this->query($sql);
        if (count($data) > 0) return "Email đã tồn tại";

        return false;
    }
    public function kiemTraSDTVaEmail($sdt, $email, $ma_tk)
    {
       
        $sql = "select thong_tin_cn.sdt from thong_tin_cn
                join tai_khoan on tai_khoan.ma_ttcn = thong_tin_cn.ma_ttcn
                where thong_tin_cn.sdt='$sdt' and not(tai_khoan.ma_tk='$ma_tk')";
        $data = $this->query($sql);
        if (count($data) > 0) return "Số điện thoại đã tồn tại";

        $sql = "select thong_tin_cn.email from thong_tin_cn
                join tai_khoan on tai_khoan.ma_ttcn = thong_tin_cn.ma_ttcn
                where thong_tin_cn.email='$email' and not(tai_khoan.ma_tk='$ma_tk')";
        $data = $this->query($sql);
        if (count($data) > 0) return "Email đã tồn tại";

        return false;
    }
    public function themTK($u, $p, $loai_tk, $hovaten, $gioitinh, $sdt, $email, $tinh, $huyen, $xa, $ngaysinh)
    {
        $sql = "insert into dia_chi(xa, huyen, tinh) 
                values('$xa','$huyen','$tinh')";

        $this->query($sql);

        $sql = "select max(ma_dc) from dia_chi";
        $data = $this->query($sql);
        if (count($data) > 0) $ma_dc = $data[0]["max(ma_dc)"];

        $sql = "insert into thong_tin_cn(ngay_sinh, gioi_tinh, sdt, email, ma_que_quan)
                values('$ngaysinh','$gioitinh','$sdt', '$email', '$ma_dc')";
        $this->query($sql);

        $sql = "select max(ma_ttcn) from thong_tin_cn";
        $data = $this->query($sql);
        if (count($data) > 0) $ma_ttcn = $data[0]["max(ma_ttcn)"];

        $sql = "insert into tai_khoan(ten_dang_nhap, mat_khau, trang_thai_tk, loai_tk, ma_ttcn) 
                values('$u','$p','hoatdong','$loai_tk', '$ma_ttcn')";

        $this->query($sql);

        $sql = "select max(ma_tk) from tai_khoan";
        $data = $this->query($sql);
        if (count($data) > 0) $ma_tk = $data[0]["max(ma_tk)"];

        if($loai_tk=="chutro"){
                $sql = "insert into chu_tro(ten_ct, ma_tk) 
                values('$hovaten','$ma_tk')";

                $this->query($sql); 
        }else{
                $sql = "insert into khach_tro(ten_kt, ma_tk) 
                values('$hovaten','$ma_tk')";
                $this->query($sql); 
        }
    }
}
