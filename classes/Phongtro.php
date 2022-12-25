<?php
    class PhongTro extends Database {

        public function hienThiPT($ma_pt){
            $data = $this->query("
                select * from phong_tro
                left join nha_tro on nha_tro.ma_nt=phong_tro.ma_nt
                left join dia_chi on dia_chi.ma_dc=nha_tro.ma_dc 
                left join chu_tro on chu_tro.ma_ct=nha_tro.ma_ct 
                left join tai_khoan on tai_khoan.ma_tk=chu_tro.ma_tk 
                left join thong_tin_cn on thong_tin_cn.ma_ttcn=tai_khoan.ma_ttcn 
                where phong_tro.ma_pt='$ma_pt'
            ");
            if(count($data)>0) return $data[0];
            else return false;
        }
        public function kiemTraOTro($ma_kt, $ma_pt){
            $data = $this->query("select * from khach_tro where ma_kt='$ma_kt' and ma_pt='$ma_pt'");
            if(count($data)>0) return true;
            else return false;
        }
        public function trongTro($ma_pt){
            $this->query("update phong_tro set trang_thai_pt='trong' where ma_pt='$ma_pt'");
        }
        public function roiTro($ma_kt){
            $this->query("update khach_tro set ma_pt=NULL where ma_kt='$ma_kt'");
        }
        public function conNguoiOtro($ma_pt){
            $data = $this->query("select ma_kt from khach_tro where ma_pt='$ma_pt'");
            if(count($data)>0) return true;
            else return false;
        }
        public function coDangOTro($ma_kt){
            $sql = "select * from khach_tro where ma_kt='$ma_kt' and not(ma_pt IS NULL)";
            $data = $this->query($sql);
            // print_r($sql);
            if(count($data)>0){
                // echo ("<script>alert(".$data.")</script>");
                return true;
            } 
            else return false;
        }
        public function layMaNt($ma_pt){
            $data = $this->query("select ma_nt from phong_tro where ma_pt='$ma_pt'");
            if(count($data) > 0) return $data[0]["ma_nt"];
        }
        public function layGiaDienNuoc($ma_pt){
            $data = $this->query("select gia_dien, gia_nuoc from phong_tro where ma_pt='$ma_pt'");
            if(count($data) > 0) return $data[0];
            else return false;
        }
        public function layThongTin($ma_pt){
            $sql = "select * from phong_tro
                    join nha_tro on nha_tro.ma_nt=phong_tro.ma_nt
                    where phong_tro.ma_pt='$ma_pt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data[0];
            else return false;
        }

        public function timKiem($ten_nt, $tinh=-1 , $huyen=-1, $xa=-1, $gia_phong_duoi = 0, $gia_phong_tren = PHP_INT_MAX,
        $gia_dien_duoi = 0, $gia_dien_tren = PHP_INT_MAX, $gia_nuoc_duoi = 0, $gia_nuoc_tren = PHP_INT_MAX,
        $dien_tich_duoi = 0, $dien_tich_tren = PHP_INT_MAX, $so_nguoi_duoi = 0, $so_nguoi_tren = PHP_INT_MAX,
        $diem_duoi = 0, $diem_tren = PHP_INT_MAX, $gac
        ){
            $sql = "select *, phong_tro.ma_pt as ma_phong from phong_tro
                    left join nha_tro on nha_tro.ma_nt = phong_tro.ma_nt
                    left join dia_chi on dia_chi.ma_dc = nha_tro.ma_dc 
                    left join anh_pt on anh_pt.ma_pt = phong_tro.ma_pt
                    where nha_tro.ten_nt like '%$ten_nt%'";
            if($tinh!=-1&&$tinh!="") $sql.= " and dia_chi.tinh='$tinh' ";
            if($huyen!=-1&&$huyen!="") $sql.= " and dia_chi.huyen='$huyen' ";
            if($xa!=-1&&$xa!="") $sql.= " and dia_chi.xa='$xa' ";
            if($gia_phong_duoi) $sql.= " and phong_tro.gia_tien>='$gia_phong_duoi' ";
            if($gia_phong_tren) $sql.= " and phong_tro.gia_tien<='$gia_phong_tren' ";
            if($gia_dien_duoi) $sql.= " and phong_tro.gia_dien>='$gia_dien_duoi' ";
            if($gia_dien_tren) $sql.= " and phong_tro.gia_dien<='$gia_dien_tren' ";
            if($gia_nuoc_duoi) $sql.= " and phong_tro.gia_nuoc>='$gia_nuoc_duoi' ";
            if($gia_nuoc_tren) $sql.= " and phong_tro.gia_nuoc<='$gia_nuoc_tren' ";
            if($dien_tich_duoi) $sql.= " and phong_tro.dien_tich>='$dien_tich_duoi' ";
            if($dien_tich_tren) $sql.= " and phong_tro.dien_tich<='$dien_tich_tren' ";
            if($so_nguoi_duoi) $sql.= " and phong_tro.so_nguoi_toi_da>='$so_nguoi_duoi' ";
            if($so_nguoi_tren) $sql.= " and phong_tro.so_nguoi_toi_da<='$so_nguoi_tren' ";
            if($diem_duoi) $sql.= " and nha_tro.diem_dg>='$diem_duoi' ";
            if($diem_tren) $sql.= " and nha_tro.diem_dg<='$diem_tren' ";
            $sql.=" and phong_tro.co_gac='$gac' group by phong_tro.ma_pt";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        
        public function layPTvaNT($ma_pt){
            $sql = "select * from phong_tro
                    join nha_tro on nha_tro.ma_nt=phong_tro.ma_nt
                    where phong_tro.ma_pt='$ma_pt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function layDsPhongTro($ma_nt){
            $sql = "select * from phong_tro
                    where ma_nt='$ma_nt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function layDsPhongTroHoatDong($ma_nt){
            $sql = "select * from phong_tro
                    where ma_nt='$ma_nt' and not(trang_thai_pt='tamngung') ";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function layDsPhuPhi($ma_ctot){
            $sql = "select * from phu_phi
                    where ma_ctot='$ma_ctot'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function layDsKhachTro($ma_pt){
            $sql = "select * from khach_tro
                    join tai_khoan on tai_khoan.ma_tk=khach_tro.ma_tk
                    join thong_tin_cn on thong_tin_cn.ma_ttcn=tai_khoan.ma_ttcn
                    join dia_chi on thong_tin_cn.ma_que_quan=dia_chi.ma_dc
                    where khach_tro.ma_pt='$ma_pt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function layDsHoaDon($ma_pt){
            $sql = "select * from chi_tiet_o_tro
                    join phong_tro on phong_tro.ma_pt=chi_tiet_o_tro.ma_pt
                    where chi_tiet_o_tro.ma_pt='$ma_pt' group by chi_tiet_o_tro.ngay_ket_thuc order by chi_tiet_o_tro.ma_ctot desc";
            $data = $this->query($sql);
            if (count($data) > 0) return $data;
            else return false;
        }
        public function tamNgungPhongTro($ma_pt){
            $sql = "update phong_tro set
                    trang_thai_pt='tamngung'
                    where ma_pt='$ma_pt'";
            $this->query($sql);
            $this->query("update khach_tro set ma_pt=NULL where ma_pt='$ma_pt'");
            $this->query("delete from yeu_cau_tham_gia where ma_pt='$ma_pt'");
        }
        public function trucXuat($ma_kt, $ma_pt){
            $sql = "update khach_tro set
                    ma_pt=NULL
                    where ma_kt='$ma_kt'";
            $this->query($sql);
            $sql = "select * from khach_tro
                    where ma_pt='$ma_pt'";
            $data = $this->query($sql);
            if (count($data) < 1) $this->query("update phong_tro set trang_thai_pt='trong' where ma_pt='$ma_pt'");
        }
        public function thanhToan($ma_pt, $ngay_kt){
            $sql = "update chi_tiet_o_tro set
                    trang_thai_tt='Đã thanh toán'
                    where ma_pt='$ma_pt' and ngay_ket_thuc='$ngay_kt'";
            $this->query($sql);
        }
        public function moLaiPhongTro($ma_pt){
            $sql = "update phong_tro set
                    trang_thai_pt='trong'
                    where ma_pt='$ma_pt'";
            $this->query($sql);
        }
        public function capNhatPhongTro($ma_pt, $so_phong, $so_nguoi_toi_da, $chieu_dai, $chieu_rong, $chieu_cao, $dien_tich, $gia_tien, $gia_dien, $gia_nuoc, $co_gac){
            $sql = "update phong_tro set
                    so_phong='$so_phong', so_nguoi_toi_da='$so_nguoi_toi_da', chieu_dai='$chieu_dai', chieu_rong='$chieu_rong', chieu_cao='$chieu_cao', dien_tich='$dien_tich', gia_tien='$gia_tien',
                    gia_dien='$gia_dien', gia_nuoc='$gia_nuoc', co_gac='$co_gac'
                    where ma_pt='$ma_pt'";
            $this->query($sql);
        }
        public function layMotPhongTro($ma_pt){
            $sql = "select * from phong_tro
                    where ma_pt='$ma_pt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data[0];
            else return false;
        }

        public function themPhongTro($ma_nt, $so_phong, $so_nguoi_toi_da, $chieu_dai, $chieu_rong, $chieu_cao, $dien_tich, $gia_tien, $gia_dien, $gia_nuoc, $co_gac){
            $sql = "insert into phong_tro
                    values(NULL, '$so_phong', '$so_nguoi_toi_da', '$chieu_dai','$chieu_rong','$chieu_cao','$dien_tich','trong','$gia_tien','$co_gac','$ma_nt','$gia_dien','$gia_nuoc')";
            $this->query($sql);
            $max = $this->query("select max(ma_pt) from phong_tro");
            return $max[0]["max(ma_pt)"];
        }
        public function themHoaDon($nbd, $nkt, $csdc, $csdm, $tien_dien, $csnc, $csnm, $tien_nuoc, $internet, $tong_tien, $ma_kt, $ma_pt){
            $sql = "insert into chi_tiet_o_tro
                    values('$nbd', '$nkt', '$csdc', '$csdm', '$tien_dien', '$csnc', '$csnm', '$tien_nuoc', '$internet', '$tong_tien', '$ma_kt', '$ma_pt','Chưa thanh toán',NULL)";
            $this->query($sql);
            $max = $this->query("select max(ma_ctot) from chi_tiet_o_tro");
            return $max[0]["max(ma_ctot)"];
        }

        public function layMotAnh($ma_pt){
            $sql = "select * from anh_pt
                    where ma_pt='$ma_pt'";
            $data = $this->query($sql);
            if (count($data) > 0) return $data[0]["ten_apt"];
            else return false;
        }
        public function layTTHoaDon($ma_pt){
            $sql = "select * from chi_tiet_o_tro
                    join phong_tro on phong_tro.ma_pt=chi_tiet_o_tro.ma_pt
                    where chi_tiet_o_tro.ma_pt='$ma_pt' order by chi_tiet_o_tro.ngay_ket_thuc desc limit 1";
            $data = $this->query($sql);
            if (count($data) > 0) return $data[0];
            else return false;
        }

        public function layMaxSoPhong($ma_nt){
            $sql = "select max(a.so_phong) from (select so_phong from phong_tro where ma_nt = '$ma_nt') a";
            $data = $this->query($sql);
            if ($data[0]["max(a.so_phong)"]) return $data[0]["max(a.so_phong)"];
            else return 0;
        }

        public function setCoNguoiPT($ma_pt){
            $this->query("update phong_tro set trang_thai_pt='conguoi' where ma_pt='$ma_pt'");
        }

    }
?>