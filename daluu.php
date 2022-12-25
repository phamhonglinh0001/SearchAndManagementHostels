<?php
include("autoload.php");
session_start();

if (isset($_SESSION["TTDN"]["ma_kt"])) {
    $ma_kt = $_SESSION["TTDN"]["ma_kt"];
} else {
    header("location:dangnhap.php");
}
if(isset($_GET["cn"])) $cn = $_GET["cn"]; else $cn="luu";

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đã lưu</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
    <link rel="stylesheet" href="assets/sidebar/sidebars.css">
    </link>
    <script src="assets/sidebar/sidebars.js"></script>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 p-3">
                <div class="d-flex rounded-3 flex-column flex-shrink-0 p-3 bg-light" >
                    
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="daluu.php?cn=luu" class="nav-link <?php if($cn=="luu") echo "active"; ?>">
                                Đang lưu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="daluu.php?cn=yeucau" class="nav-link <?php if($cn=="yeucau") echo "active"; ?>">
                                Đang yêu cầu tham gia
                            </a>
                        </li>
                        
                    </ul>
                    
                </div>
            </div>
            <div class="col-9 p-3">


                <div>
                    <div class="d-flex justify-content-start flex-wrap">
                        <?php
                        if($cn=="yeucau"){
                        $yctg = (new YeuCauThamGia)->layYCTG($ma_kt);
                        if ($yctg) foreach ($yctg as $x) {
                            $pt = (new YeuCauThamGia)->layPhongTro($x["ma_pt"]);

                            $anh = (new AnhPt)->layAllAnh($x["ma_pt"]);
                            if (!$anh) $anh = "macdinh.jpg";
                            else $anh = $anh[0]["ten_apt"];
                            echo '
                <div class="card m-3 d-inline-block" style="width:200px; height:350px;">
                    <img class="card-img-top" src="assets/img/phongtro/' . $anh . '" alt="Card image" style="width: 100%; height: 40%;">
                    <div class="card-body text-center">
                        <h4 class="card-title">Phòng số ' . $pt["so_phong"] . '</h4>
                        <h5 class="card-title">' . $pt["ten_nt"] . '</h5>
                        <p class="card-text">
                            <br>
                            ' . number_format($pt["gia_tien"], 0, ',', '.') . 'đ
                        </p>
                        <a href="chitietphongtro.php?ma_pt=' . $x["ma_pt"] . '" class="btn btn-primary">Chi tiết</a>
                    </div>
                </div>
            ';
                        }
                    }
                        ?>
                    </div>
                </div>
                <div>
                    
                    <div class="p-0 d-flex justify-content-start flex-wrap">
                        <?php
                        if($cn=="luu"){
                        $luu = (new PhongTroLuu)->layLuu($ma_kt);
                        if ($luu) foreach ($luu as $x) {
                            $pt = (new PhongTroLuu)->layPhongTro($x["ma_pt"]);

                            $anh = (new AnhPt)->layAllAnh($x["ma_pt"]);
                            if (!$anh) $anh = "macdinh.jpg";
                            else $anh = $anh[0]["ten_apt"];
                            echo '
                <div class="card m-3 d-inline-block" style="width:240px; height:350px;
                background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);">
                    <img class="card-img-top" src="assets/img/phongtro/' . $anh . '" alt="Card image" style="width: 100%; height: 50%;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Phòng số ' . $pt["so_phong"] . '</h5>
                        <h6 class="card-title">' . $pt["ten_nt"] . '</h6>
                        <p class="card-text">
                            ' . number_format($pt["gia_tien"], 0, ',', '.') . 'đ
                        </p>
                        <a href="chitietphongtro.php?ma_pt=' . $x["ma_pt"] . '" class="btn btn-sm btn-primary">Chi tiết</a>
                    </div>
                </div>
            ';
                        }
                    }
                        ?>
                    </div>

                </div>
            </div>
        </div>
</body>

</html>