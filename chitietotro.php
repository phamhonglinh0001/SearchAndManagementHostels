<?php
include("autoload.php");
session_start();

if (isset($_SESSION["TTDN"]["ma_kt"])) {
    $ma_kt = $_SESSION["TTDN"]["ma_kt"];
} else {
    header("location:dangnhap.php");
}

$pt = (new KhachTro)->layPhongTro($ma_kt);
if ($pt) {
    $nt = (new PhongTro)->layMaNt($pt);
}else{
    $nt=-1;
}
$ds_nt = (new ChiTietOTro)->layDsNt($ma_kt);
if (isset($_GET["ma_pt"]))
    $pt_chon = $_GET["ma_pt"];

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết ở trọ</title>
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
    <div class="container-fluid">
    
        <div class="row">
                <div class="col-3 p-3">
                    <div class="flex-shrink-0 p-4 rounded-3 bg-white" style="width: 280px; max-height: 700px;
                position:sticky; left: 10px; top: 10px;
                ">
                        <ul class="list-unstyled ps-0">
                            <?php
                            if (isset($ds_nt)) {
                                if ($ds_nt) foreach ($ds_nt as $x) {
                                    if ($x["ma_nt"] == $nt) {
                                        $ten = " (Đang sử dụng)";
                                        $show = " show";
                                    } else {
                                        $ten = "";
                                        $show = "";
                                    }
                                    echo '
                                <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#nt' . $x["ma_nt"] . '" aria-expanded="true">
                                ' . $x["ten_nt"] . $ten . '
                            </button>
                            <div class="collapse' . $show . '" id="nt' . $x["ma_nt"] . '">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                ';

                                    $ds_pt = (new ChiTietOTro)->layDsPt($x["ma_nt"], $ma_kt);
                                    if ($ds_pt) foreach ($ds_pt as $y) {
                                        if ($y["ma_pt"] == $pt)
                                            echo '
                                    <li class="text-center" ><a href="chitietotro.php?ma_pt=' . $y["ma_pt"] . '" class="link-dark rounded">Phòng số ' . $y["so_phong"] . $ten . '</a></li>
                                    ';
                                        else
                                            echo '
                                    <li class="text-center" ><a href="chitietotro.php?ma_pt=' . $y["ma_pt"] . '" class="link-dark rounded">Phòng số ' . $y["so_phong"] . '</a></li>
                                    ';
                                    }
                                    echo '
                                </ul>
                                </div>
                            </li>
                                ';
                                }
                            } else {
                                echo '
                                <li class="nav-item">
                                    <a class="nav-link active">
                                        Bạn chưa từng ở trọ
                                    </a>
                                </li>
                                ';
                            }
                            ?>


                        </ul>
                    </div>
                </div>
                <div class="container p-3 col-9">
                    <div class="d-flex justify-content-start flex-wrap">
                        <?php
                        if (isset($pt_chon)) {
                            $danhsach = (new ChiTietOTro)->layChiTiet($ma_kt, $pt_chon);
                            if ($danhsach) foreach ($danhsach as $x){ 

                                if($x["trang_thai_tt"]=="Chưa thanh toán") $trangthai = " text-danger";
                                else $trangthai = " text-primary";
                                echo '
                                <div class=" table-responsive ms-2 p-2"
                                    style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;"
                                >
                                    <table class="table table-bordered text-center">
                                        <tr>
                                            <th style="width: 50%">'.$x["ten_nt"].'</th>
                                            <th>Phòng số '.$x["so_phong"].'</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                ' . $x["ngay_bat_dau"] . '
                                                &#160;
                                                <i class="fas fa-long-arrow-right"></i>
                                                &#160;
                                                ' . $x["ngay_ket_thuc"] . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-danger" >
                                            ' . number_format($x["tong_tien"], 0, ',', '.') . 'đ
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="'.$trangthai.'">
                                            <b>'.$x["trang_thai_tt"].'</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#ctot'.$x["ma_ctot"].'">
                                                Chi tiết
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                ';
                                echo '
                                <div class="modal fade" id="ctot'.$x["ma_ctot"].'" tabindex="-1" aria-labelledby="ctot'.$x["ma_ctot"].'ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                ';

                                echo
                                '
                        <div class="m-3 p-2">
                        <div class="table-responsive">
                            <table class="table table-responsive text-center">
                                <tr>
                                    <th style="width: 50%;">
                                        ' . $x["ten_nt"] . '
                                    </th>
                                    <th>
                                        <a target="_blank" href="chitietphongtro.php?ma_pt=' . $x["ma_pt"] . '">Phòng số ' . $x["so_phong"] . '</a>
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
                                        ' . $x["ngay_bat_dau"] . '
                                        &#160;
                                        <i class="fas fa-long-arrow-right"></i>
                                        &#160;
                                        ' . $x["ngay_ket_thuc"] . '
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-tint"></i>
                                    Nước
                                    </th>
                                    <td>
                                        ' . $x["chi_so_nuoc_cu"] . 'm<sup>3</sup>
                                        <i class="fas fa-long-arrow-right"></i>
                                        ' . $x["chi_so_nuoc_moi"] . 'm<sup>3</sup>
                                        <br>
                                        ' . number_format($x["gia_nuoc"], 0, ',', '.') . 'đ x' . '
                                        ' . $x["chi_so_nuoc_moi"] - $x["chi_so_nuoc_cu"] . ' =
                                        ' . number_format($x["tien_nuoc"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-bolt"></i>
                                    Điện
                                    </th>
                                    <td>
                                        ' . $x["chi_so_dien_cu"] . 'kWh
                                        <i class="fas fa-long-arrow-right"></i>
                                        ' . $x["chi_so_dien_moi"] . 'kWh
                                        <br>
                                        ' . number_format($x["gia_dien"], 0, ',', '.') . 'đ x' . '
                                        ' . $x["chi_so_dien_moi"] - $x["chi_so_dien_cu"] . ' =
                                        ' . number_format($x["tien_dien"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-wifi"></i>
                                    Internet
                                    </th>
                                    <td>
                                        ' . number_format($x["tien_internet"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-home"></i>
                                    Tiền phòng
                                    </th>
                                    <td>
                                        ' . number_format($x["gia_tien"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-comment-dots"></i>
                                    Phụ phí
                                    </th>
                                    <td>';
                                $pp = (new PhuPhi)->layPP($x["ma_ctot"]);
                                // print_r($pp);
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
                                    ' . number_format($x["tong_tien"], 0, ',', '.') . 'đ
                                    </td>
                                </tr>
                                <tr>
                                    <th class="" style="width: 40%;">
                                    <i class="fas fa-money-check-alt"></i>
                                    Thanh toán
                                    </th>
                                    <td>
                                        ' . $x["trang_thai_tt"] . '
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

                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>


</body>

</html>