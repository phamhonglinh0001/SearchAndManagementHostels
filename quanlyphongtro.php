<?php
include("autoload.php");
session_start();

if (isset($_SESSION["TTDN"]["ma_ct"])) {
    $ma_ct = $_SESSION["TTDN"]["ma_ct"];
} else {
    header("location: dangnhap.php");
}

$ma_pt = $_GET["ma_pt"];

$pt = (new PhongTro)->layMotPhongTro($ma_pt);

$kt = (new PhongTro)->layDsKhachTro($ma_pt);

$otro = (new PhongTro)->layDsHoaDon($ma_pt);

$ten = (new PhongTro)->layPTvaNT($ma_pt)[0];
?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phòng trọ</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>

    <div class="container my-3 p-3 mx-auto">
        <div class="row">
            <h3 class="text-center"><?php if (isset($ten["ten_nt"])) echo $ten["ten_nt"]; ?></h3>
            <h4 class="text-center"><?php if (isset($ten["so_phong"])) echo "Phòng số " . $ten["so_phong"]; ?></h4><br><br>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th class="text-center" style="width: 25%;">
                            Số người tối đa
                        </th>
                        <td class="text-center">
                            <?php if ($pt["so_nguoi_toi_da"]) echo $pt["so_nguoi_toi_da"]; ?> người
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Chiều dài
                        </th>
                        <td class="text-center">
                            <?php if ($pt["chieu_dai"]) echo $pt["chieu_dai"]; ?>m
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Chiều rộng
                        </th>
                        <td class="text-center">
                            <?php if ($pt["chieu_rong"]) echo $pt["chieu_rong"]; ?>m
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Chiều cao
                        </th>
                        <td class="text-center">
                            <?php if ($pt["chieu_cao"]) echo $pt["chieu_cao"]; ?>m
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Diện tích
                        </th>
                        <td class="text-center">
                            <?php if ($pt["dien_tich"]) echo $pt["dien_tich"]; ?>m<sup>2</sup>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Có gác?
                        </th>
                        <td class="text-center">
                            <?php if ($pt["co_gac"] == "co") echo "Có";
                            else echo "Không" ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Giá phòng
                        </th>
                        <td class="text-center">
                            <?php if ($pt["gia_tien"]) echo number_format($pt["gia_tien"], 0, ',', '.'); ?>&#160;đ
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Giá điện
                        </th>
                        <td class="text-center">
                            <?php if ($pt["gia_dien"]) echo number_format($pt["gia_dien"], 0, ',', '.'); ?>&#160;đ

                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Giá nước
                        </th>
                        <td class="text-center">
                            <?php if ($pt["gia_nuoc"]) echo number_format($pt["gia_nuoc"], 0, ',', '.'); ?>&#160;đ

                        </td>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 25%">
                            Trạng thái
                        </th>
                        <td class="text-center">
                            <?php if ($pt["trang_thai_pt"] == "conguoi") echo "Có người";
                            if ($pt["trang_thai_pt"] == "trong") echo "Trống";
                            if ($pt["trang_thai_pt"] == "tamngung") echo "Tạm ngưng";
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <h5>Danh sách thành viên hiện tại</h5><br><br>
            <div class="d-flex justify-content-center flex-wrap">
                <?php
                if ($kt) foreach ($kt as $x) {
                    if ($x["gioi_tinh"] == "nam") if ($x["anh_dai_dien"]) $anhdaidien = $x["anh_dai_dien"];
                    else $anhdaidien = "macdinh_nam.png";
                    else if ($x["anh_dai_dien"]) $anhdaidien = $x["anh_dai_dien"];
                    else $anhdaidien = "macdinh_nu.png";
                    echo
                    '
                        <div class="card me-2 mb-3" style="width: 300px; height: 450px">
                    <div class="text-center my-2">
                        <img src="assets/img/anhdaidien/' . $anhdaidien . '" alt="Ảnh đại diện" style="width: 100px; height: 100px; border-radius: 50%;">

                    </div>
                    <div class="card-body text-center">
                        <h5>' . $x["ten_kt"] . '</h5>
                        <h6>' . $x["so_cccd"] . '</h6>
                        <h6>' . $x["bien_so_xe"] . '</h6>
                        <h6>' . $x["sdt"] . '</h6>
                        <h6>' . $x["ngay_sinh"] . '</h6>
                        <h6>' . $x["email"] . '</h6>
                        <p>' . $x["xa"] . ', ' . $x["huyen"] . ', ' . $x["tinh"] . '</p>
                    </div>
                    <div class="text-center">
                        <button onclick="trucXuat(this)" ma_pt="'.$ma_pt.'" class="btn text-danger" value="'.$x["ma_kt"].'">Trục xuất</a>
                    </div>
                </div>
                        ';
                }
                ?>


            </div>
        </div><br>
        <div class="row">
            <h5>Danh sách hóa đơn</h5><br><br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" style="min-width: 2000px;">
                    <tr>
                        <th>STT</th>
                        <th>
                            Từ
                        </th>
                        <th>
                            Đến
                        </th>
                        <th>
                            Thanh toán
                        </th>
                        <th>Thao tác</th>
                        <th>
                            Tổng cộng
                        </th>
                        <th>
                            CS Điện cũ
                        </th>
                        <th>
                            CS Điện mới
                        </th>
                        <th>
                            CS Nước cũ
                        </th>
                        <th>
                            CS Nước mới
                        </th>
                        <th>
                            Tiền điện
                        </th>
                        <th>
                            Tiền nước
                        </th>
                        <th>
                            Tiền Internet
                        </th>
                        <th>
                            Tiền phòng
                        </th>
                        <th>
                            Phụ phí
                        </th>
                    </tr>

                    <?php
                    if($otro){$soluong = count($otro);
                    if ($otro) foreach ($otro as $x) {
                        if ($x["trang_thai_tt"] == "Chưa thanh toán")
                            $tt = '<button onclick="thanhToan(this)" ma_pt="'.$ma_pt.'" ngay_kt="'.$x["ngay_ket_thuc"].'" class="btn btn-primary btn-sm">
                            Thanh toán
                        </button>';
                        else $tt = "";
                        $pp = (new PhongTro)->layDsPhuPhi($x["ma_ctot"]);
                        echo
                        '
                            <tr>
                        <td>
                            ' . $soluong . '
                        </td>
                        <td>
                        ' . $x["ngay_bat_dau"] . '
                        </td>
                        <td>
                        ' . $x["ngay_ket_thuc"] . '
                        </td>
                        <td>
                        ' . $x["trang_thai_tt"] . '
                        </td>
                        <td>
                            ' . $tt . '
                        </td>
                        <td>
                        ' . number_format($x["tong_tien"], 0, ',', '.') . 'đ
                        </td>
                        <td>
                            ' . $x["chi_so_dien_cu"] . '
                        </td>
                        <td>
                        ' . $x["chi_so_dien_moi"] . '
                        </td>
                        <td>
                        ' . $x["chi_so_nuoc_cu"] . '
                        </td>
                        <td>
                        ' . $x["chi_so_nuoc_moi"] . '
                        </td>
                        <td>
                        ' . number_format($x["tien_dien"], 0, ',', '.') . 'đ
                        </td>
                        <td>
                        ' . number_format($x["tien_nuoc"], 0, ',', '.') . 'đ
                        </td>
                        <td>
                        ' . number_format($x["tien_internet"], 0, ',', '.') . 'đ
                        </td>
                        <td>
                        ' . number_format($x["gia_tien"], 0, ',', '.') . 'đ
                        </td>
                        <td>
                             ';

                        if ($pp)
                            foreach ($pp as $y) {
                                echo
                                '
                            <p>
                                ' . $y["ten_pp"] . '&#160;' . number_format($y["gia_pp"], 0, ',', '.') . 'đ&#160;' . $y["ghi_chu"] . '
                            </p>
                            ';
                            }
                        echo '</td></tr>';

                        $soluong--;
                    }
                }
                    ?>


                </table>
            </div>
        </div>
    </div>
    <script>
        function thanhToan(ma) {
            ma_pt = (ma.getAttribute("ma_pt"));
            ngay_kt = (ma.getAttribute("ngay_kt"));
            fetch("http://localhost/lv/thanhToan.php?ma_pt=" + ma_pt+"&ngay_kt="+ngay_kt);
            location.reload();
        }
        function trucXuat(ma) {
            ma_kt = (ma.getAttribute("value"));
            ma_pt = (ma.getAttribute("ma_pt"));
            let link = "http://localhost/lv/trucxuat.php?ma_kt=" + ma_kt+"&ma_pt="+ma_pt;
            fetch(link);
            location.reload();
        }
    </script>
</body>

</html>