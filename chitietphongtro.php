<?php
include("autoload.php");
session_start();
if (isset($_SESSION["TTDN"]["ma_kt"])) {
    $ma_kt = ($_SESSION["TTDN"]["ma_kt"]);
}

$ma_pt = $_GET["ma_pt"];
$ma_nt = (new PhongTro)->layMaNt($ma_pt);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["danhgia"]) && isset($_POST["binhluan"])) {
        (new BinhLuan)->themBinhLuan($_POST["binhluan"], $ma_nt, $ma_kt);
        (new DanhGia)->themDanhGia($_POST["danhgia"], $ma_nt, $ma_kt);
    }
}
$thongtin = (new PhongTro)->layThongTin($ma_pt);
$anh_pt = (new AnhPt)->layAllAnh($ma_pt);

$dc = (new DiaChi)->layDiaChi($thongtin["ma_dc"]);
$chutro = (new ChuTro)->layTTChuTro($thongtin["ma_ct"]);

$ds_phongtro = (new PhongTro)->layDsPhongTroHoatDong($thongtin["ma_nt"]);

$binhluan = (new BinhLuan)->layDsBinhLuan($thongtin["ma_nt"]);


?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết phòng trọ</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEY_MAP ?>&callback=myMap"></script>

</head>

<body>
    <?php
    include("components/navbar.php");
    ?>

    <div class="container my-3 p-3 mx-auto">
        <div class="row">
            <div class="col">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="width: 500px; height: 420px;
                box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;">
                    <div class="carousel-indicators">
                        <?php
                        if (!$anh_pt) echo
                        '
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        
                            ';
                        else {
                            for ($i = 0; $i < count($anh_pt); $i++) {
                                echo
                                '
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $i . '" class="active" aria-current="true" aria-label="Slide ' . $i . '"></button>
                        
                                    ';
                            }
                        }
                        ?>
                    </div>
                    <div class="carousel-inner">
                        <?php
                        if (!$anh_pt) echo
                        '
                            <div class="carousel-item active">
                                <img style="width: 500px; height: 420px; object-fit: contain;" src="assets/img/phongtro/macdinh.jpg" class="d-block w-100" alt="...">
                            </div>
                            ';
                        else {
                            for ($i = 0; $i < count($anh_pt); $i++) {
                                if ($i == 0) $active = "active";
                                else $active = "";
                                echo
                                '
                                    <div class="carousel-item ' . $active . '">
                                        <a target="_blank" href="assets/img/phongtro/' . $anh_pt[$i]["ten_apt"] . '">
                                            <img style="width: 500px; height: 420px; object-fit: contain; " src="assets/img/phongtro/' . $anh_pt[$i]["ten_apt"] . '" class="d-block w-100" alt="...">
                                        </a>
                                    </div>';
                            }
                        }
                        ?>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col ">
                <div>
                    <h4>
                        <?php echo "Phòng số " . $thongtin['so_phong']; ?>
                        <?php
                        if (isset($ma_kt))
                            if ((new PhongTroLuu)->kiemPhongTroLuu($ma_kt, $ma_pt)) {
                                echo '
                                <a href="chitietphongtro_cn.php?cn=huyluu&ma_kt=' . $ma_kt . '&ma_pt=' . $ma_pt . '" class="btn ms-2 btn-sm btn-danger float-end">
                                    Hủy lưu
                                </a>
                                ';
                            } else {
                                echo '
                                <a href="chitietphongtro_cn.php?cn=luu&ma_kt=' . $ma_kt . '&ma_pt=' . $ma_pt . '" class="btn ms-2 btn-sm btn-primary float-end">
                                   Lưu
                                </a>
                                ';
                            }
                        if (isset($ma_kt))
                            if ($thongtin["trang_thai_pt"] != "tamngung")
                                if ((new PhongTro)->kiemTraOTro($ma_kt, $ma_pt)) {
                                    echo '
                            <a href="chitietphongtro_cn.php?cn=roitro&ma_pt=' . $ma_pt . '&ma_kt=' . $ma_kt . '" class="btn btn-sm btn-danger float-end">
                                Rời trọ
                            </a>
                            ';
                                } else {
                                    if ((new YeuCauThamGia)->kiemYCTG($ma_kt, $ma_pt)) {
                                        echo '
                                <a href="chitietphongtro_cn.php?cn=huyYCTG&ma_kt=' . $ma_kt . '&ma_pt=' . $ma_pt . '" class="btn btn-sm btn-danger float-end">
                                    Hủy yêu cầu tham gia
                                </a>
                                ';
                                    } else {
                                        if (!(new PhongTro)->coDangOTro($ma_kt)) echo '
                            <a href="chitietphongtro_cn.php?cn=YCTG&ma_kt=' . $ma_kt . '&ma_pt=' . $ma_pt . '" class="btn btn-sm btn-primary float-end">
                                Yêu cầu tham gia
                            </a>
                            ';
                                    }
                                }

                        ?>

                    </h4>
                    <h5>
                        <?php echo $thongtin['ten_nt']; ?>
                    </h5>
                    <p>
                        <i class="fas fa-star text-warning"></i>&#160;
                        <?php if ($thongtin["diem_dg"]) echo $thongtin["diem_dg"];
                        else echo "Không có đánh giá"; ?>
                        <br>
                        <?php
                        if ($thongtin["trang_thai_pt"] == "tamngung") echo '<span class="badge bg-danger">Đang tạm ngưng<span/>';
                        if ($thongtin["trang_thai_pt"] == "trong") echo '<span class="badge bg-primary">Trống<span/>';
                        if ($thongtin["trang_thai_pt"] == "conguoi") echo '<span class="badge bg-warning">Có người<span/>';
                        ?>
                    </p>
                    <p>
                        <b>Dài-Rộng-Cao:&#160;</b> <?php echo $thongtin['chieu_dai'] . "m - " . $thongtin['chieu_rong'] . "m - " . $thongtin['chieu_cao'] . "m"; ?>
                        <br><b>Diện tích:&#160;</b> <?php echo $thongtin["dien_tich"] . "m<sup>2</sup>"; ?>
                        <br><b>Số người tối đa:&#160;</b> <?php echo $thongtin["so_nguoi_toi_da"] . " người"; ?>
                        <br><b>Có gác:&#160;</b> <?php if ($thongtin["co_gac"] == "co") echo "Có";
                                                    else echo "Không"; ?>
                        <br><b>Giá phòng:&#160;</b> <?php echo number_format($thongtin["gia_tien"], 0, ',', '.') . "đ" ?>
                        <br><b>Giá điện:&#160;</b> <?php echo number_format($thongtin["gia_dien"], 0, ',', '.') . "đ" ?>
                        <br><b>Giá nước:&#160;</b> <?php echo number_format($thongtin["gia_nuoc"], 0, ',', '.') . "đ" ?>
                        <br><b>Địa chỉ:&#160;</b> <?php echo $dc["xa"] . ", " . $dc["huyen"] . ", " . $dc["tinh"]; ?>
                        <br><b>Chủ trọ:&#160;</b> <?php echo $chutro["ten_ct"] ?>
                        <br><b>Email:&#160;</b> <?php echo $chutro["email"] ?>
                        <br><b>Điện thoại:&#160;</b> <?php echo $chutro["sdt"] ?>

                    </p>
                </div>
            </div>
        </div>
        <br>
        <div>
            <div class="table-responsive">
                <table class="bg-white table table-bordered" style="box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;">
                    <tr>
                        <th style="width: 150px;">
                            Mô tả
                        </th>
                        <td>
                            <pre><?php echo $thongtin["mo_ta"] ?></pre>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px;">
                            Nội quy
                        </th>
                        <td>
                            <pre><?php echo $thongtin["noi_quy_nt"] ?></pre>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <div class="rounded-4" id="googleMap" style="height: 400px;
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;">
        </div>

        <br>
        <div class="" style="overflow-x: auto; white-space: nowrap; position: relative">

            <?php
            if ($ds_phongtro) foreach ($ds_phongtro as $x) {
                $anh = (new AnhPt)->layAllAnh($x["ma_pt"]);
                if (!$anh) $anh = "macdinh.jpg";
                else $anh = $anh[0]["ten_apt"];
                echo
                '
                        <div class="card m-3 d-inline-block itemRoom" style="width:200px; height:300px;
                        background-image: linear-gradient(45deg, #fbc2eb 0%, #a6c1ee 100%);">
                            <img class="card-img-top" src="assets/img/phongtro/' . $anh . '" alt="Card image" style="width: 100%; height: 40%;">
                            <div class="card-body text-center">
                                <h5 class="card-title">Phòng số ' . $x["so_phong"] . '</h5>
                                <h6 class="card-title">' . $thongtin["ten_nt"] . '</h6>
                                <p class="card-text">
                                    ' . number_format($x["gia_tien"], 0, ',', '.') . 'đ
                                </p>
                                <a href="chitietphongtro.php?ma_pt=' . $x["ma_pt"] . '" class="btn btn-sm btn-primary">Chi tiết</a>
                            </div>
                        </div>
                        ';
            }
            ?>
        </div>
        <?php
        if (isset($ma_kt)) {
            $ktDG = (new DanhGia)->kiemTraDG($ma_kt, $ma_nt);
            if ($ktDG)
                include("thembinhluan_layout.php");
        }

        ?>
        <section>
            <div class="container my-5 py-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12 col-lg-10">
                        <div class="card text-dark">
                        <div class="card-body p-4">
                        
                        <h4 class="mb-0">Bình luận về nhà trọ</h4>
                        </div>
                        <?php
                if (!$binhluan) echo ' <p class="fw-light ms-4 mb-4 pb-2">Chưa có bình luận</p>';
                else {
                    foreach ($binhluan as $x) {
                        if ($x["anh_dai_dien"]) $avt = $x["anh_dai_dien"];
                        else {
                            if ($x["gioi_tinh"] == "nam") $avt = "macdinh_nam.png";
                            else $avt = "macdinh_nu.png";
                        }
                        if($x["ma_bl"]==$binhluan[0]["ma_bl"]) $line = "";
                        else $line = '<hr class="my-0" />';
                        echo
                        $line.'
                            <div class="card-body p-4">
                                <div class="d-flex flex-start">
                                    <img class="rounded-circle shadow-1-strong me-3" src="assets/img/anhdaidien/'.$avt.'" alt="avatar" width="60" height="60" />
                                    <div>
                                        <h6 class="fw-bold mb-1">'.$x["ten_kt"].'</h6>
                                        <div class="d-flex align-items-center mb-3">
                                            <p class="mb-0">
                                                '.$x["thoi_gian_bl"].'
                                            </p>
                                        </div>
                                        <p class="mb-0">
                                            '.$x["noi_dung_bl"].'
                                        </p>
                                    </div>
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
        </section>
    </div>
    <script>
        //Khoi tao Map
        function initialize() {
            //Khai bao cac thuoc tinh
            var mapProp = {
                //Tam ban do, quy dinh boi kinh do va vi do
                center: new google.maps.LatLng(<?php echo $dc['vi_do'] ?>, <?php echo $dc['kinh_do'] ?>),
                //set default zoom cua ban do khi duoc load
                zoom: 15,
                //Dinh nghia type
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            //Truyen tham so cho cac thuoc tinh Map cho the div chua Map
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(<?php echo $dc['vi_do'] ?>, <?php echo $dc['kinh_do'] ?>),
            });

            marker.setMap(map);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</body>

</html>