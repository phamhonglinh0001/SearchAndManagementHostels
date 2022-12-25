<?php
include("autoload.php");
session_start();

if (!isset($_SESSION["TTDN"]["ma_ct"])) header("location: dangnhap.php");
else {
    $ma_ct = $_SESSION["TTDN"]["ma_ct"];
    $ma_pt = $_GET["ma_pt"];
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

    if (isset($_FILES["themanh"])) {
        $sl = count($_FILES["themanh"]["name"]);
        $max = (new AnhPt)->layMaxId()+1;
        for($i = 0; $i < $sl; $i++){
            if ($_FILES["themanh"]["error"][$i] != 4) {
                $tenfile = $_FILES["themanh"]["name"][$i];
                $arr = explode(".", $tenfile);
                $temp = end($arr);
                $dir = "./assets/img/phongtro/" . $max . "." . $temp;
                if (file_exists($dir)) unlink($dir);
                move_uploaded_file($_FILES["themanh"]["tmp_name"][$i], $dir);
                (new AnhPt)->themAnh($max.".".$temp, $ma_pt);
                $max++;
            }
        }
        unset($_FILES["themanh"]);
    }

    $ten_file = (array_keys($_FILES));

    for ($i = 0; $i < count($ten_file); $i++) {
        if ($_FILES[$ten_file[$i]]["error"] != 4) {
            $tenfile = $_FILES[$ten_file[$i]]["name"];
            $arr = explode(".", $tenfile);
            $temp = end($arr);
            $ma_apt = substr($ten_file[$i],3);
            $ten_apt = (new AnhPt)->layTenAnh($ma_apt);
            $dir = "./assets/img/phongtro/" . $ten_apt . "." . $temp;
            if (file_exists($dir)) unlink($dir);
            move_uploaded_file($_FILES[$ten_file[$i]]["tmp_name"], $dir);
            print_r($dir);
            (new AnhPt)->capNhat($ten_apt."." . $temp, $ma_apt);

        }
    }

    

    (new PhongTro)->capNhatPhongTro($ma_pt, $so_phong, $so_nguoi_toi_da, $chieu_dai, $chieu_rong, $chieu_cao, $dien_tich, $gia_tien, $gia_dien, $gia_nuoc, $co_gac);

    $_SESSION["err"] = "Cập nhật thành công!";

}

    


$nt = (new PhongTro)->layMotPhongTro($ma_pt);
$anh = (new AnhPt)->layAllAnh($ma_pt);
?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa phòng trọ</title>
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
    <script>
        function xoaAnh(ma){
            ma_apt = (ma.getAttribute("value"));
            fetch("http://localhost/lv/xoaanhpt.php?ma_apt="+ma_apt);
            location.reload();
        }
    </script>
    <div class="container mx-auto p-3" style="width: 1000px;">
        <h4 class="text-center">
            Sửa phòng trọ
        </h4>
        <div class="text-center">
            <span class="text-danger">
                <?php if (isset($_SESSION["err"])) {
                    echo $_SESSION["err"];
                    unset($_SESSION["err"]);
                } ?>
            </span>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mx-auto p-3 rounded-3 bg-white" style="width: 700px;">
                <div class="input-group">
                    <span style="width: 100px;" class="input-group-text">Số phòng</span>
                    <input required name="so_phong" type="text" class="form-control"
                        value="<?php echo $nt["so_phong"] ?>"
                    >
                </div>
                <br>
                <div class="input-group">
                <span style="width: 150px;" class="input-group-text">Số người tối đa</span>
                <input required name="so_nguoi_toi_da" type="text" class="form-control" placeholder="Số người tối đa"
                    value="<?php 
                        if(isset($nt["so_nguoi_toi_da"])) echo $nt["so_nguoi_toi_da"];
                    ?>"
                >
                </div>
                <br>
                <div class="input-group">
                    <span style="width: 100px;" class="input-group-text">Dài</span>
                    <input required name="chieu_dai" type="number" step="any" class="form-control" placeholder="Chiều dài"
                    value="<?php 
                        if(isset($nt["chieu_dai"])) echo $nt["chieu_dai"];
                    ?>"
                    >
                    <span style="width: 100px;" class="input-group-text">Rộng</span>
                    <input required name="chieu_rong" type="number" step="any" class="form-control" placeholder="Chiều rộng"
                    value="<?php 
                        if(isset($nt["chieu_rong"])) echo $nt["chieu_rong"];
                    ?>"
                    >
                    <span style="width: 100px;" class="input-group-text">Cao</span>
                    <input required name="chieu_cao" type="number" step="any" class="form-control" placeholder="Chiều cao"
                    value="<?php 
                        if(isset($nt["chieu_cao"])) echo $nt["chieu_cao"];
                    ?>"
                    >
                </div>
                <br>
                <div class="input-group"><span style="width: 100px;" class="input-group-text">Giá phòng</span>
                <input required name="gia_tien" type="number" class="form-control" placeholder="Giá phòng"
                value="<?php 
                        if(isset($nt["gia_tien"])) echo $nt["gia_tien"];
                    ?>"
                >
                </div><br>
                <div class="input-group"><span style="width: 100px;" class="input-group-text">Giá điện</span>
                <input required name="gia_dien" type="number" class="form-control" placeholder="Giá điện"
                value="<?php 
                        if(isset($nt["gia_dien"])) echo $nt["gia_dien"];
                    ?>"
                >
                </div><br>
                <div class="input-group"><span style="width: 100px;" class="input-group-text">Giá nước</span>
                <input required name="gia_nuoc" type="number" class="form-control" placeholder="Giá nước"
                value="<?php 
                        if(isset($nt["gia_nuoc"])) echo $nt["gia_nuoc"];
                    ?>"
                >
                </div><br>
                <input class="form-check-input" type="checkbox" value="co" id="co_gac" name="co_gac" <?php if($nt["co_gac"]=="co") echo "checked"; ?>>
                <label class="form-check-label" for="co_gac">Có gác</label>
                <br><br>
                <div class="d-flex flex-wrap">
                    <?php 
                        if($anh) foreach($anh as $x){

                            echo 
                            '
                            <div class="card me-3 mb-3" style="width: 200px; height: 200px;
                            box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
                            <img class="card-img-top" src="assets/img/phongtro/'.$x["ten_apt"].'" alt="Ảnh phòng trọ"
                            style="width: 100%; height: 70%;"
                            >
                            <input type="file" name="anh'.$x["ma_apt"].'" id="anh'.$x["ma_apt"].'" style="display:none">
                            <div class="card-body text-center">
                            <label for="anh'.$x["ma_apt"].'">
                                <a class="btn btn-primary btn-sm">Thay đổi</a>
                            </label>
                            <a onclick="xoaAnh(this)" class="btn btn-sm btn-danger" value="'.$x["ma_apt"].'">Xóa</a>
                            </div>
                            </div>
                            
                            ';
                        }
                    ?>
                    
                </div>
                <br>
                <div class="input-group">
                <span style="width: 100px;" class="input-group-text">Thêm ảnh</span>
                    <input multiple name="themanh[]" type="file" class="form-control" >
                    
                </div>
                
            </div><br>
            <div class="text-center">
                <button type="submit" class="btn btn-danger">
                    Lưu thay đổi
                </button>
                <a class="btn btn-primary" href="quanlynhatro.php">
                    Trở về
                </a>
            </div>
        </form>
    </div>
</body>

</html>