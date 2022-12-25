<?php
    class ThongTinCN extends Database
    {
        public function layTTCN($ma_tk, $loai_tk)
        {
            if($loai_tk=="khachtro")
            $sql = "select * from tai_khoan
                    join thong_tin_cn on tai_khoan.ma_ttcn = thong_tin_cn.ma_ttcn
                    join khach_tro on khach_tro.ma_tk = tai_khoan.ma_tk
                    join dia_chi on dia_chi.ma_dc = thong_tin_cn.ma_que_quan
                    where tai_khoan.ma_tk='$ma_tk'";
            else
            $sql = "select * from tai_khoan
                    join thong_tin_cn on tai_khoan.ma_ttcn = thong_tin_cn.ma_ttcn
                    join chu_tro on chu_tro.ma_tk = tai_khoan.ma_tk
                    join dia_chi on dia_chi.ma_dc = thong_tin_cn.ma_que_quan
                    where tai_khoan.ma_tk='$ma_tk'";

            $data = $this->query($sql);
            if (count($data) > 0) return $data[0];
            else return false;
        }

        public function layMaDc($ma_ttcn){
            $sql = "select ma_que_quan from thong_tin_cn
                    where ma_ttcn='$ma_ttcn'";

            $data = $this->query($sql);
            if (count($data) > 0) return $data[0]["ma_que_quan"];
            else return false;
        }

        public function capNhatTTCN($ns, $gt, $sdt, $e, $ma_ttcn)
    {
        $sql = "update thong_tin_cn set
                ngay_sinh='$ns', gioi_tinh='$gt', sdt='$sdt', email='$e'
                where ma_ttcn='$ma_ttcn'";
        $this->query($sql);
    }
    }
