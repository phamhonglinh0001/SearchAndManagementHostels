<?php
include("autoload.php");
session_start();
if (isset($_SESSION["TTDN"]["ma_ct"])) {
    $ma_ct = $_SESSION["TTDN"]["ma_ct"];
} else {
    header("location: dangnhap.php");
}


?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhà trọ</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/jquery/jquery.js"></script>

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">

    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEY_MAP ?>&callback=myMap"></script>

</head>

<body>
    <script>
        function taoMap(viDo, kinhDo, idDiv) {
            //Khai bao cac thuoc tinh
            var mapProp = {
                //Tam ban do, quy dinh boi kinh do va vi do
                center: new google.maps.LatLng(viDo, kinhDo),
                //set default zoom cua ban do khi duoc load
                zoom: 15,
                //Dinh nghia type
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            //Truyen tham so cho cac thuoc tinh Map cho the div chua Map
            var map = new google.maps.Map(document.getElementById(idDiv), mapProp);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(viDo, kinhDo),
            });

            marker.setMap(map);
        }
    </script>
    <?php
    include("components/navbar.php");
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 p-3">
                <div class="flex-shrink-0 p-4 rounded-3 bg-white" style="width: 280px; height: 480px; overflow-y: auto;
                position: fixed; left: 10px; top: 70px;
                box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
                ">
                    <ul class="list-unstyled ps-0">
                        <a href="themnhatro.php" class="btn btn-primary align-items-center rounded collapsed">
                            Thêm nhà trọ
                        </a>
                        <br><br>
                        <?php
                        $ds_nt = (new ChuTro)->layDsNt($ma_ct);
                        if (isset($_GET["ma_nt"])) $ma_nt = $_GET["ma_nt"];
                        else
                            if (isset($_GET["ma_pt"])) {
                            $ma_pt = $_GET["ma_pt"];
                            $ma_nt = (new PhongTro)->layMaNt($ma_pt);
                        }
                        if (isset($ds_nt)) if ($ds_nt) foreach ($ds_nt as $x) {
                            if (isset($ma_nt) && $ma_nt == $x["ma_nt"]) $show = " show";
                            else $show = "";
                            echo '
                                <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#nt' . $x["ma_nt"] . '" aria-expanded="true">
                                ' . $x["ten_nt"] . '
                            </button>
                            <div class="collapse' . $show . '" id="nt' . $x["ma_nt"] . '">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li class="text-center" ><a href="quanlynhatro.php?ma_nt=' . $x["ma_nt"] . '" class="text-warning link-dark rounded">TỔNG QUAN</a></li>
                                ';

                            $ds_pt = (new ChuTro)->laySoPhong($x["ma_nt"]);
                            if ($ds_pt) foreach ($ds_pt as $y) {

                                echo '
                                    <li class="text-center" ><a href="quanlynhatro.php?ma_pt=' . $y["ma_pt"] . '" class="link-dark rounded">Phòng số ' . $y["so_phong"] . '</a></li>
                                    ';
                            }
                            echo '
                                </ul>
                                </div>
                            </li>
                                ';
                        }
                        ?>


                    </ul>
                </div>
            </div>
            <div class="container p-3 col-9">

                <?php
                if (isset($_GET["ma_nt"])) {
                    $ma_nt = $_GET["ma_nt"];
                    $nt = (new NhaTro)->layNhaTro($ma_nt);

                    if ($nt) {
                        $dc = (new DiaChi)->layDiaChi($nt["ma_dc"]);

                        if ($nt["diem_dg"]) $diem = '<i class="fas fa-star fa-lg text-warning"></i>&#160;' . $nt["diem_dg"];
                        else $diem = '<i class="far fa-star fa-lg"></i>&#160;Chưa có đánh giá';

                        if ($nt["trang_thai_nt"] == "hoatdong") {
                            $trangthai = "Đang hoạt động";
                            $ngung_mo = '<a onclick="tamNgungNhaTro(this)" value="' . $ma_nt . '" class="btn btn-warning">Tạm ngưng</a>';
                            $dis = " ";
                        } else {
                            $trangthai = "Tạm ngưng";
                            $ngung_mo = '<a onclick="moLaiNhaTro(this)" value="' . $ma_nt . '" class="btn btn-warning">Mở lại</a>';
                            $dis = " disabled";
                        }

                        echo '
                        <div class="btn-group d-flex justify-content-end mb-3" role="group">
                            
                            <a href="suanhatro.php?id=' . $ma_nt . '" class="btn btn-warning">Sửa nhà trọ</a>
                            <a href="themphongtro.php?ma_nt=' . $ma_nt . '" class="btn btn-warning ' . $dis . '">Thêm phòng trọ</a>
                            <a href="themhoadon.php?ma_nt=' . $ma_nt . '" class="btn btn-warning ' . $dis . '">Thêm hóa đơn</a>
                            <a target="_blank" href="thongke.php?ma_nt='.$ma_nt.'" class="btn btn-warning">Thống kê</a>
                            ' . $ngung_mo . '
                            </div>
                        <div class="card mb-3" style="border-radius: 15px;">
                        
                        <div class="card-body p-4">
                            <h3 class="mb-3">' . $nt["ten_nt"] . '</h3>
                            <p class="small mb-0">' . $diem . '<span class="mx-2">|</span>
                            ' . $trangthai . '
                            <span class="mx-2">|</span> 
                            Thành lập ' . $nt["ngay_lap"] . '
                            </p>
                            <p class="mt-2 text-uppercase">
                                <span class="text-muted small">
                                ' . $dc["xa"] . ', ' . $dc["huyen"] . ', ' . $dc["tinh"] . '
                                </span>
                            </p>
                            <hr class="my-4">
                            <div class="d-flex justify-content-start flex-column">
                                <p class="mb-0">
                                    <span class="text-uppercase me-2">
                                        <i class="fas fa-cog me-2"></i><span class="text-muted small">Mô tả:</span>
                                    </span>
                                    <pre>' . $nt["mo_ta"] . '</pre>
                                </p>
                                <p class="mb-0">
                                    <span class="text-uppercase me-2">
                                        <i class="fas fa-cog me-2"></i><span class="text-muted small">Nội quy:</span>
                                    </span>
                                    <pre>' . $nt["noi_quy_nt"] . '</pre>
                                </p>
                                
                                
                            </div>
                        </div>
                    </div>    

                    <div id="mapNhaTro" class="rounded-6"
                        style="height: 400px; box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;"
                    >
                    </div>

                    <script>
                        google.maps.event.addDomListener(window, "load", taoMap(' . $dc["vi_do"] . ',' . $dc["kinh_do"] . ', "mapNhaTro"));
                    </script>
                        ';
                    }

                    $binhluan = (new BinhLuan)->layDsBinhLuan($ma_nt);

                    echo '
                    <section>
                        <div class="container-fluid mt-4 p-0 rounded-4"
                            style="box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;"
                        >
                            <div class="d-flex justify-content-center">
                                <div class="col-md-12">
                                    <div class="card text-dark">
                                    <div class="card-body p-4">
                                    
                                    <h4 class="mb-0">Bình luận về nhà trọ</h4>
                                    </div>
                    ';

                    if (!$binhluan) echo ' <p class="fw-light mb-4 p-4">Chưa có bình luận</p>';
                    else {
                        foreach ($binhluan as $x) {
                            if ($x["anh_dai_dien"]) $avt = $x["anh_dai_dien"];
                            else {
                                if ($x["gioi_tinh"] == "nam") $avt = "macdinh_nam.png";
                                else $avt = "macdinh_nu.png";
                            }
                            if ($x["ma_bl"] == $binhluan[0]["ma_bl"]) $line = "";
                            else $line = '<hr class="my-0" />';
                            echo
                            $line . '
                                <div class="card-body p-4">
                                    <div class="d-flex flex-start">
                                        <img class="rounded-circle shadow-1-strong me-3" src="assets/img/anhdaidien/' . $avt . '" alt="avatar" width="60" height="60" />
                                        <div>
                                            <h6 class="fw-bold mb-1">' . $x["ten_kt"] . '</h6>
                                            <div class="d-flex align-items-center mb-3">
                                                <p class="mb-0">
                                                    ' . $x["thoi_gian_bl"] . '
                                                </p>
                                            </div>
                                            <p class="mb-0">
                                                ' . $x["noi_dung_bl"] . '
                                            </p>
                                        </div>
                                    </div>
                                </div>    
                            ';
                        }
                    }
                    echo '
                                </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    ';
                } else if (isset($_GET["ma_pt"])) {
                    $ma_pt = $_GET["ma_pt"];
                    $pt = (new PhongTro)->layMotPhongTro($ma_pt);

                    if ($pt) {
                        if ($pt["trang_thai_pt"] == "tamngung") {
                            $trangthai = "Tạm ngưng";
                            $ngung_mo = '<a onclick="moLaiPhongTro(this)" value="' . $ma_pt . '" class="btn btn-warning">Mở phòng trọ</a>';
                        } else if ($pt["trang_thai_pt"] == "conguoi") {
                            $trangthai = "Có người";
                            $ngung_mo = '<a onclick="tamNgungPhongTro(this)" value="' . $ma_pt . '" class="btn btn-warning">Tạm ngưng phòng trọ</a>';
                        } else {
                            $trangthai = "Trống";
                            $ngung_mo = '<a onclick="tamNgungPhongTro(this)" value="' . $ma_pt . '" class="btn btn-warning">Tạm ngưng phòng trọ</a>';
                        }
                        if ($pt["co_gac"] == "co") {
                            $gac = "Có gác";
                        } else {
                            $gac = "Không gác";
                        }

                        echo '
                        <div class="btn-group mb-3" role="group">
                            
                            <a href="suaphongtro.php?ma_pt=' . $ma_pt . '" class="btn btn-warning">Sửa phòng trọ</a>
                            ' . $ngung_mo . '
                        </div>

                        <div class="card mb-3" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h3 class="mb-3">Phòng số ' . $pt["so_phong"] . '</h3>
                            <p class="small mb-0">
                                ' . $trangthai . '
                            <span class="mx-2">|</span>
                                Tối đa ' . $pt["so_nguoi_toi_da"] . ' người
                            <span class="mx-2">|</span> 
                                ' . $pt["dien_tich"] . ' m<sup>2</sup>
                            <span class="mx-2">|</span>
                                ' . $gac . '
                            </p>

                            <p class="mt-2 text-uppercase">
                                <span class="text-muted small">
                                Dài x Rộng x Cao: ' . $pt["chieu_dai"] . ' x ' . $pt["chieu_rong"] . ' x ' . $pt["chieu_cao"] . ' (m)
                                </span>
                            </p>
                            <hr class="my-4">
                            <div class="d-flex justify-content-start flex-column">
                                <p class="mb-0">
                                    <span class="text-uppercase me-4">
                                    <i class="fas fa-home me-2"></i><span class="text-muted small">Giá phòng: </span>
                                        ' . number_format($pt["gia_tien"], 0, ',', '.') . 'đ
                                    </span>
                                    <span class="text-uppercase me-4">
                                        <i class="fas fa-plug me-2"></i><span class="text-muted small">Giá điện: </span>
                                        ' . number_format($pt["gia_dien"], 0, ',', '.') . 'đ
                                    </span>
                                    <span class="text-uppercase me-4">
                                    <i class="fas fa-tint me-2"></i><span class="text-muted small">Giá nước: </span>
                                        ' . number_format($pt["gia_nuoc"], 0, ',', '.') . 'đ
                                    </span>
                                </p>
                                
                            </div>
                        </div>
                    </div>  
                        ';

                        $kt = (new PhongTro)->layDsKhachTro($ma_pt);

                        echo '
                        <div class="bg-white rounded-4 p-2"
                        style="box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;"
                    >
                        <h5 class="text-center">
                            Thành viên
                        </h5>
                        <hr class="my-2">
                        <div class="d-flex justify-content-center p-3 flex-wrap">
                        ';
                        // print_r($kt);
                        if ($kt) foreach ($kt as $j) {
                            if ($j["anh_dai_dien"]) $avt = $j["anh_dai_dien"];
                            else if ($j["gioi_tinh"] == "nam") $avt = "macdinh_nam.png";
                            else $avt = "macdinh_nu.png";
                            echo '
                            <div class="text-center mx-3">
                            <img src="assets/img/anhdaidien/' . $avt . '" class="rounded-circle mb-3" style="width: 100px; height: 100px;" alt="Avatar" />

                            <h5 class="mb-2">
                                <a target="_blank" href="thongtinkhachtro.php?ma_kt=' . $j["ma_kt"] . '"><strong>' . $j["ten_kt"] . '</strong></a>
                            </h5>
                            <p class="text-muted">
                                <a onclick="trucXuat(this)" ma_pt="'.$ma_pt.'" value="' . $j["ma_kt"] . '" class="text-danger btn btn-sm">Trục xuất</a>
                            </p>
                        </div>
                            ';
                        }
                        else {
                            echo '<p>Không có thành viên</p>';
                        }

                        echo '
                        </div>
                        </div>
                        ';
                        if(isset($_GET["nbd"]) && isset($_GET["nkt"])) $ds_hd = (new ChiTietOTro)->layChiTietCT($ma_pt,$_GET["nbd"], $_GET["nkt"]);
                        else if(isset($_GET["nbd"])) $ds_hd = (new ChiTietOTro)->layChiTietCT($ma_pt,$_GET["nbd"]);
                        else if(isset($_GET["nkt"])) $ds_hd = (new ChiTietOTro)->layChiTietCT($ma_pt,NULL,$_GET["nkt"]);
                        else $ds_hd = (new ChiTietOTro)->layChiTietCT($ma_pt);

                        echo '
                        <div id="filter" class="input-group mt-4 mb-2">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-primary text-white" style="width: 120px; font-size: 15px">
                                    Ngày bắt đầu
                                </span>
                                <input type="date" id="ngay_bd" class="form-control" placeholder="">
                                <span class="input-group-text bg-primary text-white" style="width: 120px; font-size: 15px">
                                    Ngày kết thúc
                                </span>
                                <input type="date" id="ngay_kt" class="form-control" placeholder="">
                                <button onClick="locNgay()" class="btn btn-primary" type="submit">Áp dụng</button>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-start flex-wrap">
                        ';

                        if($ds_hd) foreach ($ds_hd as $i){
                            if($i["trang_thai_tt"]=="Chưa thanh toán") {
                                $thanhtoan = '<button onclick="thanhToan(this)" ma_pt="'.$ma_pt.'" ngay_kt="'.$i["ngay_ket_thuc"].'" class="mt-2 btn btn-primary btn-sm">
                                Thanh toán
                            </button>';

                                $hinhthuc = '<div class="bg-danger text-center text-white"
                                style="border-radius: 5px 5px 0 0;"
                            >
                                Chưa thanh toán
                            </div>';
                            }
                            
                            else {
                                $thanhtoan = '';
                                $hinhthuc = '<div class="bg-primary text-center text-white"
                                style="border-radius: 5px 5px 0 0;"
                            >
                                Đã thanh toán
                            </div>';
                            }
                             
                            echo '
                            <div class=" table-responsive ms-4 p-2 mb-4"
                                style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;"
                            >
                                '.$hinhthuc.'
                                <table class="table table-bordered text-center">

                                    <tr>
                                        <td>
                                            ' . $i["ngay_bat_dau"] . '
                                            &#160;
                                            <i class="fas fa-long-arrow-right"></i>
                                            &#160;
                                            ' . $i["ngay_ket_thuc"] . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-danger" >
                                        ' . number_format($i["tong_tien"], 0, ',', '.') . 'đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#ctot'.$i["ma_ctot"].'">
                                            Chi tiết
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            ';
                            echo '
                            <div class="modal fade" id="ctot'.$i["ma_ctot"].'" tabindex="-1" aria-labelledby="ctot'.$i["ma_ctot"].'ModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                    </div>
                            ';

                            echo
                        '
                        <div class="mb-3 me-3 p-2">
                        <div class="table-responsive">
                            <table class="table table-responsive text-center">
                            <tr>
                                <th style="width: 50%;">
                                    ' . $i["ten_nt"] . '
                                </th>
                                <th>
                                    <a target="_blank" href="chitietphongtro.php?ma_pt=' . $i["ma_pt"] . '">Phòng số ' . $i["so_phong"] . '</a>
                                </th>
                            </tr>
                        </table>
                            <table class="table table-borderless text-center">
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-clock"></i>
                                    Thời điểm
                                    </th>
                                    <td>
                                        ' . $i["ngay_bat_dau"] . '
                                        &#160;
                                        <i class="fas fa-long-arrow-right"></i>
                                        &#160;
                                        ' . $i["ngay_ket_thuc"] . '
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-tint"></i>
                                    Nước
                                    </th>
                                    <td>
                                        ' . $i["chi_so_nuoc_cu"] . 'm<sup>3</sup>
                                        <i class="fas fa-long-arrow-right"></i>
                                        ' . $i["chi_so_nuoc_moi"] . 'm<sup>3</sup>
                                        <br>
                                        ' . number_format($i["gia_nuoc"], 0, ',', '.') . 'đ x' . '
                                        ' . $i["chi_so_nuoc_moi"] - $i["chi_so_nuoc_cu"] . ' =
                                        ' . number_format($i["tien_nuoc"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-bolt"></i>
                                    Điện
                                    </th>
                                    <td>
                                        ' . $i["chi_so_dien_cu"] . 'kWh
                                        <i class="fas fa-long-arrow-right"></i>
                                        ' . $i["chi_so_dien_moi"] . 'kWh
                                        <br>
                                        ' . number_format($i["gia_dien"], 0, ',', '.') . 'đ x' . '
                                        ' . $i["chi_so_dien_moi"] - $i["chi_so_dien_cu"] . ' =
                                        ' . number_format($i["tien_dien"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-wifi"></i>
                                    Internet
                                    </th>
                                    <td>
                                        ' . number_format($i["tien_internet"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-home"></i>
                                    Tiền phòng
                                    </th>
                                    <td>
                                        ' . number_format($i["gia_tien"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-comment-dots"></i>
                                    Phụ phí
                                    </th>
                                    <td>';
                        $pp = (new PhuPhi)->layPP($i["ma_ctot"]);
                        if ($pp) foreach ($pp as $y) {
                            echo
                            '
                                    <div>
                                        ' . number_format($y["gia_pp"], 0, ',', '.') . 'đ
                                        ' . $y["ten_pp"] . '
                                        ' . $y["ghi_chu"] . '
                                    </div>
                                    ';
                        }

                        echo '</td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-cart-arrow-down"></i>
                                    Tổng cộng
                                    </th>
                                    <td class="text-danger" style="border-top: 1px solid black">
                                    ' . number_format($i["tong_tien"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-money-check-alt"></i>
                                    Thanh toán
                                    </th>
                                    <td>
                                        ' . $i["trang_thai_tt"] . '
                                        '.$thanhtoan.'
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    ';
                    echo ' </div>
                                </div>
                              </div>';
                        }
                        else echo '<h6>Không có hóa đơn</h6>';
                        echo '
                            </div>
                        </div>
                        ';
                    }
                }
                ?>
            </div>

        </div>

    </div>


    <script>
        function trucXuat(ma) {
            ma_kt = (ma.getAttribute("value"));
            ma_pt = (ma.getAttribute("ma_pt"));
            let link = "http://localhost/lv/trucxuat.php?ma_kt=" + ma_kt + "&ma_pt=" + ma_pt;
            // alert(link)
            fetch(link);
            location.reload();
        }

        function tamNgungNhaTro(ma) {
            ma_nt = (ma.getAttribute("value"));
            fetch("http://localhost/lv/tamngungnhatro.php?ma_nt=" + ma_nt);
            location.reload();
        }

        function moLaiNhaTro(ma) {
            ma_nt = (ma.getAttribute("value"));
            fetch("http://localhost/lv/molainhatro.php?ma_nt=" + ma_nt);
            location.reload();
        }

        function tamNgungPhongTro(ma) {
            ma_pt = (ma.getAttribute("value"));
            fetch("http://localhost/lv/tamngungphongtro.php?ma_pt=" + ma_pt);
            location.reload();
        }

        function moLaiPhongTro(ma) {
            ma_pt = (ma.getAttribute("value"));
            fetch("http://localhost/lv/molaiphongtro.php?ma_pt=" + ma_pt);
            location.reload();
        }
        function thanhToan(ma) {
            ma_pt = (ma.getAttribute("ma_pt"));
            ngay_kt = (ma.getAttribute("ngay_kt"));
            fetch("http://localhost/lv/thanhToan.php?ma_pt=" + ma_pt+"&ngay_kt="+ngay_kt);
            location.reload();
        }
        function locNgay(){
            let nbd = $("#ngay_bd").val();
            let nkt = $("#ngay_kt").val();

            var ma_pt = undefined;
            let link = window.location.href;
            if(link.indexOf("&")>-1) ma_pt = link.substring(link.indexOf("ma_pt=")+6, link.indexOf("&"));
            else if(link.indexOf("#")>-1) ma_pt = link.substring(link.indexOf("ma_pt=")+6, link.indexOf("#"));
            else ma_pt = link.substring(link.indexOf("ma_pt=")+6);

            link = link.substring(0, link.indexOf("?"))+"?ma_pt="+ma_pt;

            if(nbd && nkt) window.location=(link+`&nbd=${nbd}&nkt=${nkt}#filter`);
            else if(nbd) window.location=(link+`&nbd=${nbd}#filter`);
            else if(nkt) window.location=(link+`&nkt=${nkt}#filter`);
            else window.location=(link+"#filter");
        }
    </script>

</body>

</html>