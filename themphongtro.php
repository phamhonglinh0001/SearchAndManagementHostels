<?php
include("autoload.php");
session_start();

if (!isset($_SESSION["TTDN"]["ma_ct"])) header("location: dangnhap.php");
else {
    $ma_ct = $_SESSION["TTDN"]["ma_ct"];
    $ma_nt = $_GET["ma_nt"];
    $maxsophong = (new PhongTro)->layMaxSoPhong($ma_nt);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $so_phong = $_POST["so_phong"];
    $so_nguoi_toi_da = $_POST["so_nguoi_toi_da"];
    $chieu_dai = $_POST["chieu_dai"];
    $chieu_rong = $_POST["chieu_rong"];
    $chieu_cao = $_POST["chieu_cao"];
    $dien_tich = round($chieu_dai*$chieu_rong, 1);
    $gia_tien = $_POST["gia_tien"];
    $gia_dien = $_POST["gia_dien"];
    $gia_nuoc = $_POST["gia_nuoc"];
    if (isset($_POST["co_gac"])) $co_gac = $_POST["co_gac"];
    else $co_gac = "khong";

    $max_mapt = (new PhongTro)->themPhongTro($ma_nt, $so_phong, $so_nguoi_toi_da, $chieu_dai, $chieu_rong, $chieu_cao, $dien_tich, $gia_tien, $gia_dien, $gia_nuoc, $co_gac);

    if (isset($_FILES["anh_pt"])) {
        $sl = count($_FILES["anh_pt"]["name"]);
        $max = (new AnhPt)->layMaxId()+1;
        for($i = 0; $i < $sl; $i++){
            if ($_FILES["anh_pt"]["error"][$i] != 4) {
                $tenfile = $_FILES["anh_pt"]["name"][$i];
                $arr = explode(".", $tenfile);
                $temp = end($arr);
                $dir = "./assets/img/phongtro/" . $max . "." . $temp;
                if (file_exists($dir)) unlink($dir);
                move_uploaded_file($_FILES["anh_pt"]["tmp_name"][$i], $dir);
                (new AnhPt)->themAnh($max.".".$temp, $max_mapt);
                $max++;
            }
        }
    }

    $_SESSION["err"] = "Thêm thành công!";
}
if (!isset($_SESSION["TTDN"]["ma_ct"])) header("location: dangnhap.php");
else {
    $maxsophong = (new PhongTro)->layMaxSoPhong($ma_nt);
}

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phòng trọ</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    
    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
</head>

<body>
    <?php
    include("components/navbar.php");
    ?>

    <div class="container mx-auto p-3" style="width: 1000px;">
        <h4 class="text-center">
            Thêm mới phòng trọ
        </h4>
        <div class="text-center">
            <span class="text-danger">
                <?php if (isset($_SESSION["err"])) {
                    echo $_SESSION["err"];
                    unset($_SESSION["err"]);
                } ?>
            </span>
        </div>
        <form class="" action="" method="post" enctype="multipart/form-data">
            <div class="mx-auto p-3 rounded-3 bg-white" style="width: 700px;">
                <div class="input-group">
                    <span class="input-group-text">Số phòng</span>
                    <input required name="so_phong" type="text" class="form-control"
                        value="<?php echo $maxsophong+1 ?>"
                    >
                </div>
                <br>
                <input required name="so_nguoi_toi_da" type="text" class="form-control" placeholder="Số người tối đa">
                <br>
                <div class="input-group">
                    <span class="input-group-text">Kích thước</span>
                    <input required name="chieu_dai" type="number" step="any" class="form-control" placeholder="Chiều dài">
                    <input required name="chieu_rong" type="number" step="any" class="form-control" placeholder="Chiều rộng">
                    <input required name="chieu_cao" type="number" step="any" class="form-control" placeholder="Chiều cao">
                </div>
                <br>
                <input required name="gia_tien" type="number" class="form-control" placeholder="Giá phòng">
                <br>
                <input required name="gia_dien" type="number" class="form-control" placeholder="Giá điện">
                <br>
                <input required name="gia_nuoc" type="number" class="form-control" placeholder="Giá nước">
                <br>
                <input class="form-check-input" type="checkbox" value="co" id="co_gac" name="co_gac">
                <label class="form-check-label" for="co_gac">Có gác</label>
                <br><br>
                <div class="input-group">
                    <span class="input-group-text">Thêm ảnh</span>
                    <input accept="image/*" multiple name="anh_pt[]" type="file" class="form-control">
                </div>
                <br>
            </div>
            <br>
            <div class="text-center">
                <button type="submit" class="btn btn-danger">
                    Thêm mới
                </button>
                <a class="btn btn-primary" href="quanlynhatro.php?id=<?php echo $ma_nt; ?>">
                    Trở về
                </a>
            </div>
        </form>
    </div>
</body>

</html>