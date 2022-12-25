<?php
include("autoload.php");
session_start();

if (isset($_SESSION["TTDN"]["ma_ct"])) {
    $ma_ct = $_SESSION["TTDN"]["ma_ct"];
} else {
    header("location: dangnhap.php");
}

$dsyc = (new YeuCauThamGia)->layYCTG_CT($ma_ct);

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu cầu tham gia</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>

    <div class="container my-3 p-3 mx-auto">
        <h4>
            Danh sách yêu cầu tham gia
        </h4>
        <div class="d-flex justify-content-start flex-wrap">
            <!-- <a href="xacnhanyeucau.php?ma_kt=' . $x[" ma_kt"] . '&ma_pt=' . $x["ma_pt"] . '" class="btn btn-danger">
            Xác nhận
            </a>
            <a href="chitietphongtro_cn.php?dh=yeucau&cn=huyYCTG&ma_kt=' . $x["ma_kt"] . '&ma_pt=' . $x["ma_pt"] . '" class="btn btn-danger">
            Hủy
            </a> -->
            <?php
                if($dsyc) foreach($dsyc as $x){

                    $ttkt = (new KhachTro)->layThongTinKhachTro($x["ma_kt"]);

                    if ($ttkt["anh_dai_dien"]) $avt = $ttkt["anh_dai_dien"];
                    else if ($ttkt["gioi_tinh"] == "nam") $avt = "macdinh_nam.png";
                    else $avt = "macdinh_nu.png";

                    echo '
                    
                    <div class="rounded-4 bg-white p-4 mb-2 me-2 mt-4" style="">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="text-center me-3">
                                <img src="assets/img/anhdaidien/'.$avt.'" class="rounded-circle mb-1" style="width: 100px; height: 100px;" alt="Avatar" />

                                <h5 class="mb-2">
                                    <a class="text-uppercase" target="_blank" href="thongtinkhachtro.php?ma_kt='.$ttkt["ma_kt"].'">'.$ttkt["ten_kt"].'</a>
                                </h5>
                            </div>
                            <div class="d-flex flex-column text-center ms-3">
                                <h6 class="display-6 mb-0 font-weight-bold" style="color: #1C2331;"> Phòng số '.$x["so_phong"].' </h6>
                                <span class="small" style="color: #868B94">'.$x["ten_nt"].'</span>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <a href="xacnhanyeucau.php?ma_kt=' . $x["ma_kt"] . '&ma_pt=' . $x["ma_pt"] . '" class="btn btn-sm btn-primary">Chấp nhận</a>
                            <a href="chitietphongtro_cn.php?dh=yeucau&cn=huyYCTG&ma_kt=' . $x["ma_kt"] . '&ma_pt=' . $x["ma_pt"] . '" class="btn btn-sm btn-danger">Từ chối</a>
                        </div>
                    </div>
                    
                    ';
                }else{
                    echo '<p>Không có yêu cầu</p>';
                }
            ?>
            
        </div>
    </div>

</body>

</html>