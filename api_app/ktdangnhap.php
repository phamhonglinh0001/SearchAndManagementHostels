<?php
    header('Content-Type: application/json; charset=utf-8');
    include("../autoload.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);

        if($data) {
            $u = $data["u"];
            $p = md5($data["p"]);
            
            $kq = (new TaiKhoan)->kttaikhoan($u, $p);
            if($kq) echo json_encode(array("status"=>true, "ma_kt"=>$kq));
            else echo json_encode(array("status"=>false));
            
        }
        else echo json_encode(array("status"=>false));
    }
?>