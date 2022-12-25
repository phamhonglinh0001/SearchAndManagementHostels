<?php
include("autoload.php");
session_start();

if (isset($_SESSION["TTDN"]["ma_ct"])) {
    $ma_ct = $_SESSION["TTDN"]["ma_ct"];
} else {
    header("location: dangnhap.php");
}

$ma_nt = $_GET["id"];

$danhgia = (new DanhGia)->layDsDanhGia($ma_nt);

if ($danhgia) {
    $tong = 0;
    foreach ($danhgia as $x) {
        $tong += $x["diem_dg"];
    }
    $diemdanhgia = round($tong / count($danhgia), 1);
}

$nhatro = (new NhaTro)->layNhaTro($ma_nt);

$diachi = (new DiaChi)->layDiaChi($nhatro["ma_dc"]);

$dsbinhluan = (new BinhLuan)->layDsBinhLuan($ma_nt);

$dsphongtro = (new PhongTro)->layDsPhongTro($ma_nt);

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết nhà trọ</title>
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
    <script>
        //Khoi tao Map
        function initialize() {
            //Khai bao cac thuoc tinh
            var mapProp = {
                //Tam ban do, quy dinh boi kinh do va vi do
                center: new google.maps.LatLng(<?php echo $diachi["vi_do"] ?>, <?php echo $diachi["kinh_do"] ?>),
                //set default zoom cua ban do khi duoc load
                zoom: 10,
                //Dinh nghia type
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            //Truyen tham so cho cac thuoc tinh Map cho the div chua Map
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(<?php echo $diachi["vi_do"] ?>, <?php echo $diachi["kinh_do"] ?>),
            });

            marker.setMap(map);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <div class="container-fluid my-3 p-5">
        <div class="row p-3">
            <div class="">
                <h4 class="text-center">
                    <?php echo $nhatro["ten_nt"]?>
                </h4>

                <h5 class="text-center">
                    <i class="fas fa-star text-warning"></i>
                    <?php
                    if ($danhgia) echo $diemdanhgia;
                    else echo "Chưa có đánh giá";
                    ?>
                </h5>
                <br>
                <div class="table-responsive">
                    <table class="table-bordered table">
                        <tr>
                            <th class="text-end" style="width: 100px;">

                                Ngày lập
                            </th>
                            <td class="ps-2">
                                <?php
                                if (isset($nhatro["ngay_lap"])) echo $nhatro["ngay_lap"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-end" style="width: 100px;">

                                Trạng thái
                            </th>
                            <td class="ps-2">
                                <?php
                                if ($nhatro["trang_thai_nt"] == "hoatdong") echo "Đang hoạt động";
                                else echo "Đã tạm ngưng";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-end" style="width: 100px;">

                                Mô tả
                            </th>
                            <td class="ps-2">
                                <?php
                                if (isset($nhatro["mo_ta"])) echo $nhatro["mo_ta"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-end" style="width: 100px;">

                                Nội quy</th>
                            <td class="ps-2">
                                <?php
                                if (isset($nhatro["noi_quy_nt"])) echo $nhatro["noi_quy_nt"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-end" style="width: 100px;">

                                Địa chỉ

                            </th>
                            <td class="ps-2">
                                <?php
                                echo $diachi["xa"] . ', ' . $diachi["huyen"] . ', ' . $diachi["tinh"]
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="row p-3">
            <div class="col">
                <div class="mx-auto bg-secondary" id="googleMap" style="width: 100%; height:400px;">
                </div>
            </div>
            <div class="col">
                <h5 class="text-center">
                    Bình luận
                </h5>
                <div style="height: 400px; overflow-y:auto;overflow-x:hidden;">
                    <?php
                    if ($dsbinhluan)
                        foreach ($dsbinhluan as $x) {
                            if ($x["anh_dai_dien"]) $avt = $x["anh_dai_dien"];
                            else {
                                if ($x["gioi_tinh"] == "nam") $avt = "macdinh_nam.png";
                                else $avt = "macdinh_nu.png";
                            }
                            echo
                            '
                        
                        <div class="row pb-3">
                            <div class="col-5">
                                <div class="text-center">
                                    <img 
                                        src="assets/img/anhdaidien/' . $avt . '"
                                        style="width:30px; height:30px; border-radius: 50%;" />
                                </div>
                               
                                <div class="text-center" style="font-size: 12px;">
                                    ' . $x["ten_kt"] . '
                                </div>
                                <div class="text-center" style="font-size: 12px;">
                                    ' . $x["thoi_gian_bl"] . '
                                </div>
                            </div>
                            <div class="col-7">
                            ' . $x["noi_dung_bl"] . '
                            </div>
                        </div>
                        
                        ';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="row p-5">
            <h3>
                Danh sách phòng trọ
            </h3>
            <h5 class="text-end">
                <?php 
                    if($nhatro["trang_thai_nt"]=="hoatdong")
                    echo 
                    '
                    <a class="btn btn-primary" href="themhoadon.php?ma_nt='.$ma_nt.'">
                    Thêm hóa đơn
                    </a>
                    ';
                ?>
                
                <a href="themphongtro.php?ma_nt=<?php echo $ma_nt; ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i>
                    Thêm phòng trọ
                </a>
            </h5>
            <div class="d-flex justify-content-start p-3 flex-wrap">
                <?php
                    if($dsphongtro)
                    foreach($dsphongtro as $x){
                        $anh = (new PhongTro)->layMotAnh($x["ma_pt"]);
                        if(!$anh) $anh = "macdinh.jpg";
                        if($x["trang_thai_pt"]=="conguoi") $trangthai = "<i class='fas fa-users text-success'></i>&#160Có khách";
                        if($x["trang_thai_pt"]=="trong") $trangthai = "<i class='fas fa-ban text-warning'></i>&#160Trống";
                        if($x["trang_thai_pt"]=="tamngung") {
                            $trangthai = "<i class='fas fa-ban text-danger'></i>&#160Tạm ngưng";
                        }
                        if($x["trang_thai_pt"]!="tamngung"){
                            $tamngung = '<a onclick="tamNgungPhongTro(this)" value="'.$x["ma_pt"].'" class="btn card-link text-decoration-none text-danger">
                            <i class="fas fa-times"></i>
                            Tạm ngưng
                            </a>';
                        }
                        else $tamngung = '<a onclick="moLaiPhongTro(this)" value="'.$x["ma_pt"].'" class="btn card-link text-decoration-none text-success">
                        <i class="fas fa-lock-open"></i>
                        Mở lại
                        </a>';
                        echo 
                        '
                        <div class="card me-3 mb-3" style="width: 250px; height: 350px;">
                            <img class="" src="assets/img/phongtro/'.$anh.'" alt="Ảnh phòng trọ"
                            style="width: 100%; height: 50%;"
                            >
                            <div class="card-body">
                                <h5 class="card-title text-center">Phòng số '.$x["so_phong"].'</h5>
                                <p class="card-text text-center">
                                    '.$trangthai.'
                                </p>
                                <a href="suaphongtro.php?ma_nt='.$ma_nt.'&ma_pt='.$x["ma_pt"].'" class="card-link text-decoration-none text-primary">
                                    <i class="fas fa-edit"></i>    
                                    Sửa
                                </a>
                                '.$tamngung.'
                                <br>
                                <a href="quanlyphongtro.php?ma_pt='.$x["ma_pt"].'" class="card-link text-decoration-none text-warning">
                                <i class="fas fa-list"></i>
                                Quản lý
                                </a>
                            </div>
                           
                        </div>
                        ';
                    }
                ?>
                
            </div>
        </div>
    </div>
    <script>
        function tamNgungPhongTro(ma){
            ma_pt = (ma.getAttribute("value"));
            fetch("http://localhost/lv/tamngungphongtro.php?ma_pt="+ma_pt);
            location.reload();
        }
        function moLaiPhongTro(ma){
            ma_pt = (ma.getAttribute("value"));
            fetch("http://localhost/lv/molaiphongtro.php?ma_pt="+ma_pt);
            location.reload();
        }
    </script>
</body>

</html>