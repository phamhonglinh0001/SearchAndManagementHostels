<?php
include("autoload.php");
session_start();
if (isset($_SESSION["TTDN"]["ma_ct"])) {
    $ma_ct = $_SESSION["TTDN"]["ma_ct"];
} else {
    header("location: dangnhap.php");
}
$ma_nt = $_GET["ma_nt"];
$ten_nt = (new NhaTro)->layTenNhaTro($ma_nt);
$dsmaphongtro = (new NhaTro)->layDsSoPhongTro($ma_nt);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nbd = $_POST["nbd"];
    $nkt = $_POST["nkt"];
    $so_phong = $_POST["so_phong"];
    $csnc = $_POST["csnc"];
    $csnm = $_POST["csnm"];
    $gia_nuoc = $_POST["gia_nuoc"];
    $tien_nuoc = $_POST["tien_nuoc"];
    $csdc = $_POST["csdc"];
    $csdm = $_POST["csdm"];
    $gia_dien = $_POST["gia_dien"];
    $tien_dien = $_POST["tien_dien"];

    $gia_phong = (new PhongTro)->layMotPhongTro($so_phong)["gia_tien"];

    if($_POST["internet"]) $internet=$_POST["internet"]; else $internet=0;

    $tong_pp = 0;

    $ten_pp1 = $_POST["ten_pp1"];
    $gia_pp1 = $_POST["gia_pp1"];
    $gc_pp1 = $_POST["gc_pp1"];
    if($gia_pp1) $tong_pp+=$gia_pp1;

    $ten_pp2 = $_POST["ten_pp2"];
    $gia_pp2 = $_POST["gia_pp2"];
    $gc_pp2 = $_POST["gc_pp2"];
    if($gia_pp2) $tong_pp+=$gia_pp2;

    $ten_pp3 = $_POST["ten_pp3"];
    $gia_pp3 = $_POST["gia_pp3"];
    $gc_pp3 = $_POST["gc_pp3"];
    if($gia_pp3) $tong_pp+=$gia_pp3;

    $ten_pp4 = $_POST["ten_pp4"];
    $gia_pp4 = $_POST["gia_pp4"];
    $gc_pp4 = $_POST["gc_pp4"];
    if($gia_pp4) $tong_pp+=$gia_pp4;

    $ten_pp5 = $_POST["ten_pp5"];
    $gia_pp5 = $_POST["gia_pp5"];
    $gc_pp5 = $_POST["gc_pp5"];
    if($gia_pp5) $tong_pp+=$gia_pp5;

    $tong_tien = $tien_dien + $tien_nuoc + $gia_phong + $internet + $tong_pp;

    $dskhachtro = (new PhongTro)->layDsKhachTro($so_phong);

    if($dskhachtro) foreach($dskhachtro as $x){
        $max = (new PhongTro)->themHoaDon($nbd, $nkt, $csdc, $csdm, $tien_dien, $csnc, $csnm, $tien_nuoc, $internet, $tong_tien, $x["ma_kt"], $so_phong);
        if($gia_pp1) (new PhuPhi)->themPP($max, $ten_pp1, $gia_pp1, $gc_pp1);
        if($gia_pp2) (new PhuPhi)->themPP($max, $ten_pp2, $gia_pp2, $gc_pp2);
        if($gia_pp3) (new PhuPhi)->themPP($max, $ten_pp3, $gia_pp3, $gc_pp3);
        if($gia_pp4) (new PhuPhi)->themPP($max, $ten_pp4, $gia_pp4, $gc_pp4);
        if($gia_pp5) (new PhuPhi)->themPP($max, $ten_pp5, $gia_pp5, $gc_pp5);
    }
}


?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hóa đơn</title>
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
        <form class="rounded-3 bg-white p-3" action="" method="post">
        <h3 class="text-center">
            <?php
            echo $ten_nt;
            ?>
        </h3>
        <h4 class="text-center">
            Thêm hóa đơn
        </h4>
        <br>
        <div class="input-group">
            <span class="input-group-text" style="width: 200px;">Ngày bắt đầu</span>
            <input required id="nbd" name="nbd" type="date" class="form-control">
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-text" style="width: 200px;">Ngày kết thúc</span>
            <input required id="nkt" name="nkt" type="date" class="form-control">
        </div>
        <br>
        <script>
            function setGiaTri(data){
                if(data.ma_ctot){
                    // console.log(data);
                    $("#csdc").val(data.chi_so_dien_moi);
                    $("#csnc").val(data.chi_so_nuoc_moi);
                    $("#gia_dien").val(data.gia_dien);
                    $("#gia_nuoc").val(data.gia_nuoc);
                    let date = new Date(data.ngay_ket_thuc);
                    date.setDate(date.getDate()+1);
                    $("#nbd").val(date.toISOString().slice(0, 10));
                }else{
                    $("#csdc").val("");
                    $("#csnc").val("");
                    $("#gia_dien").val(data.gia_dien);
                    $("#gia_nuoc").val(data.gia_nuoc);
                    $("#nbd").val("");
                }
            }
            function layHoaDon(ma_pt) {
                fetch("http://localhost/lv/laythongtinphongtro.php?ma_pt=" + ma_pt)
                    .then((response) => response.json())
                    .then((data) => setGiaTri(data));
            }
            function tinhTienNuoc(){
                const nuoccu = $("#csnc").val();
                const nuocmoi = $("#csnm").val();
                const gianuoc = $("#gia_nuoc").val();
                const tiennuoc = $("#tien_nuoc")
                if(nuoccu!="" && nuocmoi!="" && gianuoc!="") {
                    let tong = (nuocmoi-nuoccu)*gianuoc;
                    tiennuoc.val(tong);
                    
                }
                else {
                    tiennuoc.val("");
                }
            }
            function tinhTienDien(){
                const diencu = $("#csdc").val();
                const dienmoi = $("#csdm").val();
                const giadien = $("#gia_dien").val();
                const tiendien = $("#tien_dien")
                if(diencu!="" && dienmoi!="" && giadien!="") {
                    let tong = (dienmoi-diencu)*giadien;
                    tiendien.val(tong);
                    
                }
                else {
                    tiendien.val("");
                }
            }
        </script>
        <div class="input-group">
            <span class="input-group-text" style="width: 200px;">Số phòng</span>
            <select onchange="layHoaDon(this.value)" name="so_phong" class="form-control form-select">
                <option value="-1">Chọn số phòng</option>
                <?php
                if ($dsmaphongtro) foreach ($dsmaphongtro as $x) {
                    echo
                    '
                        <option value="' . $x["ma_pt"] . '">' . $x["so_phong"] . '</option>
                        ';
                }
                ?>
            </select>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table-borderless table text-center">
                <tr>
                    <th style="width: 25%;">
                        CS Nước cũ
                    </th>
                    <th style="width: 25%;">
                        CS Nước mới
                    </th>
                    <th style="width: 25%;">
                        Giá Nước
                    </th>
                    <th style="width: 25%;">
                        Thành tiền
                    </th>
                </tr>
                <tr>
                    <td>
                        <input onchange="tinhTienNuoc()" type="number" step="1" required class="form-control" id="csnc" name="csnc">
                    </td>
                    <td>
                        <input onchange="tinhTienNuoc()" type="number" step="1" required class="form-control" id="csnm" name="csnm">
                    </td>
                    <td>
                        <input onchange="tinhTienNuoc()" type="number" step="1" required class="form-control" id="gia_nuoc" name="gia_nuoc">
                    </td>
                    <td>
                        <input type="number" step="1" required class="form-control" id="tien_nuoc" name="tien_nuoc">
                    </td>
                </tr>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table-borderless text-center table">
                <tr>
                    <th style="width: 25%;">
                        CS Điện cũ
                    </th>
                    <th style="width: 25%;">
                        CS Điện mới
                    </th>
                    <th style="width: 25%;">
                        Giá điện
                    </th>
                    <th style="width: 25%;">
                        Thành tiền
                    </th>
                </tr>
                <tr>
                    <td>
                        <input onchange="tinhTienDien()" type="number" step="1" required class="form-control" id="csdc" name="csdc">
                    </td>
                    <td>
                        <input onchange="tinhTienDien()" type="number" step="1" required class="form-control" id="csdm" name="csdm">
                    </td>
                    <td>
                        <input onchange="tinhTienDien()" type="number" step="1" required class="form-control" id="gia_dien" name="gia_dien">
                    </td>
                    <td>
                        <input type="number" step="1" required class="form-control" id="tien_dien" name="tien_dien">
                    </td>
                </tr>
            </table>
        </div>
        <div class="input-group">
            <span class="input-group-text" style="width: 200px;">Tiền Internet</span>
            <input required id="internet" name="internet" type="number" step="1" class="form-control">
        </div>
        <br>
        <div class="table-respnsive">
            <table class="table table-borderless text-center">
                <tr>
                    <th style="width: 10%;">
                        STT
                    </th>
                    <th style="width: 30%;">
                        Tên phụ phí
                    </th>
                    <th style="width: 30%;">
                        Giá phụ phí
                    </th>
                    <th style="width: 30%;">
                        Ghi chú
                    </th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>
                        <input type="text" name="ten_pp1" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="gia_pp1" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="gc_pp1" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <input type="text" name="ten_pp2" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="gia_pp2" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="gc_pp2" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        <input type="text" name="ten_pp3" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="gia_pp3" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="gc_pp3" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        <input type="text" name="ten_pp4" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="gia_pp4" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="gc_pp4" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>
                        <input type="text" name="ten_pp5" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="gia_pp5" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="gc_pp5" class="form-control">
                    </td>
                </tr>
            </table>
        </div>
        <div class="text-center">
            <button class="btn btn-danger" type="submit">
                Thêm
            </button>
            <a href="quanlynhatro.php?id=<?php echo $ma_nt ?>" class="btn btn-primary">
                Trở về
            </a>
        </div>
        </form>
    </div>

</body>

</html>