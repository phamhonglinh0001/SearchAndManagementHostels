<?php
include("autoload.php");
session_start();
$kq = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["ten_nt"]) $ten_nt = $_POST["ten_nt"]; else $ten_nt="";
    if($_POST["gia_tren"]) $gia_tren = $_POST["gia_tren"]; else $gia_tren = NULL;
    if($_POST["gia_duoi"]) $gia_duoi = $_POST["gia_duoi"]; else $gia_duoi = NULL;
    if($_POST["dien_tren"]) $dien_tren = $_POST["dien_tren"]; else $dien_tren = NULL;
    if($_POST["dien_duoi"]) $dien_duoi = $_POST["dien_duoi"]; else $dien_duoi = NULL;
    if($_POST["nuoc_tren"]) $nuoc_tren = $_POST["nuoc_tren"]; else $nuoc_tren = NULL;
    if($_POST["nuoc_duoi"]) $nuoc_duoi = $_POST["nuoc_duoi"]; else $nuoc_duoi = NULL;
    if($_POST["dientich_tren"]) $dientich_tren = $_POST["dientich_tren"]; else $dientich_tren = NULL;
    if($_POST["dientich_duoi"]) $dientich_duoi = $_POST["dientich_duoi"]; else $dientich_duoi = NULL;
    if($_POST["songuoi_tren"]) $songuoi_tren = $_POST["songuoi_tren"]; else $songuoi_tren = NULL;
    if($_POST["songuoi_duoi"]) $songuoi_duoi = $_POST["songuoi_duoi"]; else $songuoi_duoi = NULL;
    if($_POST["diem_tren"]) $diem_tren = $_POST["diem_tren"]; else $diem_tren = NULL;
    if($_POST["diem_duoi"]) $diem_duoi = $_POST["diem_duoi"]; else $diem_duoi = NULL;
    $gac = $_POST["gac"];
    $tinh = $_POST["tinh"];
    $huyen = $_POST["huyen"];
    $xa = $_POST["xa"];

    $kq = (new PhongTro)->timKiem($ten_nt, $tinh, $huyen, $xa, $gia_duoi, $gia_tren,$dien_duoi,$dien_tren
    ,$nuoc_duoi, $nuoc_tren,$dientich_duoi, $dientich_tren, $songuoi_duoi, $songuoi_tren, $diem_duoi, $diem_tren, $gac);
}
?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm phòng trọ</title>
    
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
</head>

<body onload="layTinh()"
    
>
    <?php
    include("components/navbar.php");
    ?>

    <div class="container my-3 p-3 mx-auto">



        <div>
            <div class="bg-white p-4 rounded-4"
                
            >
                <form action="" method="post">
                    <div>
                        <div class="input-group">
                            <div class="input-group mb-3">
                                <input type="text" name="ten_nt" class="form-control" placeholder="Nhập tên nhà trọ">
                                <button class="btn btn-primary" type="submit">Tìm</button>
                            </div>
                        </div>
                        <div class="input-group">
                            <!-- <span class="input-group-text" style="width: 150px">Thành phố/Tỉnh</span> -->
                            <select style="width: 33%;" onchange="layHuyen(this)" class="form-control form-select" id="tinh" name="tinh">
                                <option value="-1">Chọn Thành phố/Tỉnh</option>
                            </select>
                            <!-- <span class="input-group-text" style="width: 150px">Quận/Huyện</span> -->
                            <select style="width: 33%;" onchange="layXa(this)" class="form-control form-select" id="huyen" name="huyen">
                                <option value="-1">Chọn Quận/Huyện</option>
                            </select>
                            <!-- <span class="input-group-text" style="width: 150px">Phường/Xã</span> -->
                            <select style="width: 33%;" class="form-control form-select" id="xa" name="xa">
                                <option value="-1">Chọn Phường/Xã</option>
                            </select>
                        </div>

                        <div class="mt-3 input-group">
                            <span class="input-group-text" style="width: 100px;">
                                Giá phòng
                            </span>
                            <input type="number" class="form-control" name="gia_duoi" placeholder="Từ">
                            <input type="number" class="form-control" name="gia_tren" placeholder="Đến">
                        </div>

                        <div class="mt-3 input-group">
                            <span class="input-group-text" style="width: 100px;">
                                Giá điện
                            </span>
                            <input type="number" class="form-control" name="dien_duoi" placeholder="Từ">
                            <input type="number" class="form-control" name="dien_tren" placeholder="Đến">
                        </div>

                        <div class="mt-3 input-group">
                            <span class="input-group-text" style="width: 100px;">
                                Giá nước
                            </span>
                            <input type="number" class="form-control" name="nuoc_duoi" placeholder="Từ">
                            <input type="number" class="form-control" name="nuoc_tren" placeholder="Đến">
                        </div>
                        <div class="mt-3 input-group">
                            <span class="input-group-text" style="width: 100px;">
                                Đánh giá
                            </span>
                            <input type="number" min="0" max="5" class="form-control" name="diem_duoi" placeholder="Từ">
                            <input type="number" min="0" max="5" class="form-control" name="diem_tren" placeholder="Đến">
                        </div>
                        <div class="mt-3 input-group">
                            <span class="input-group-text" style="width: 100px;">
                                Diện tích
                            </span>
                            <input type="number" class="form-control" name="dientich_duoi" placeholder="Từ">
                            <input type="number" class="form-control" name="dientich_tren" placeholder="Đến">
                        </div>
                        <div class="mt-3 input-group">
                            <span class="input-group-text" style="width: 100px;">
                                Số người
                            </span>
                            <input type="number" class="form-control" name="songuoi_duoi" placeholder="Từ">
                            <input type="number" class="form-control" name="songuoi_tren" placeholder="Đến">
                        </div>
                        <div class="mt-3 input-group">
                            <span class="input-group-text" style="width: 100px;">
                                Gác
                            </span>
                            <select class="form-control form-select" name="gac">
                                <option value="co">Có</option>
                                <option value="khong">Không</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div class="d-flex justify-content-start flex-wrap">
                <?php 
                    if($kq) foreach ($kq as $x){
                        $anh = (new AnhPt)->layAllAnh($x["ma_pt"]);
                        if(!$anh) $anh = "macdinh.jpg";
                        else $anh = $anh[0]["ten_apt"];
                        if($x["diem_dg"]) $diem = $x["diem_dg"];
                        else $diem = "Chưa có đánh giá";
                        echo 
                        '
                        <div class="card m-3" 
                        style="width:300px; height:450px;
                        background-image: linear-gradient(to top, #f3e7e9 0%, #e3eeff 99%, #e3eeff 100%);">
                            <img class="card-img-top" src="assets/img/phongtro/'.$anh.'" alt="Card image" style="width: 100%; height: 40%;">
                            <div class="card-body text-center">
                                <h4 class="card-title">Phòng số '.$x["so_phong"].'</h4>
                                <h5 class="card-title">'.$x["ten_nt"].'</h5>
                                <p class="card-text">
                                    <i class="fas fa-star text-warning"></i>&#160;'.$diem.'
                                    <br>
                                    ' . number_format($x["gia_tien"], 0, ',', '.') . 'đ
                                    <br>
                                    '.$x["xa"].', '.$x["huyen"].', '.$x["tinh"].'
                                </p>
                                <a target="_blank" href="chitietphongtro.php?ma_pt='.$x["ma_phong"].'" class="btn btn-primary">Chi tiết</a>
                            </div>
                        </div>
                        ';
                    } 
                    else echo "<h5>Không có kết quả phù hợp</h5>"
                ?>
                
            </div>
        </div>
    </div>
    <script>
        function layTinh() {
            const tinh = document.getElementById("tinh");
            const ds = fetch("https://provinces.open-api.vn/api/p/")
                .then((response) => response.json())
                .then(data => {
                    data.map((v) => {
                        var option = document.createElement("option");
                        option.text = v.name;
                        option.value = v.name;
                        option.setAttribute("code", v.code);
                        tinh.add(option);
                    })
                });

        }

        function layHuyen(tinh) {
            const huyen = document.getElementById("huyen");
            let code_tinh = $("option:selected", tinh).attr("code");
            const ds = fetch("https://provinces.open-api.vn/api/p/" + code_tinh + "?depth=2")
                .then((response) => response.json())
                .then(data => {
                    huyen.options.length = 0;
                    let x = document.createElement("option");
                    x.text = "Chọn huyện";
                    x.value = "-1";
                    huyen.add(x);
                    data["districts"].map((v) => {
                        var option = document.createElement("option");
                        option.text = v.name;
                        option.value = v.name;
                        option.setAttribute("code", v.code);
                        huyen.add(option);
                    })
                });
                document.getElementById("xa").options.length = 0;
            let x = document.createElement("option");
            x.text = "Chọn xã";
            x.value = "-1";
            document.getElementById("xa").add(x);
        }

        function layXa(huyen) {
            const xa = document.getElementById("xa");
            let code_huyen = $("option:selected", huyen).attr("code");
            const ds = fetch("https://provinces.open-api.vn/api/d/" + code_huyen + "?depth=2")
                .then((response) => response.json())
                .then(data => {
                    xa.options.length = 0;
                    let x = document.createElement("option");
                    x.text = "Chọn xã";
                    x.value = "-1";
                    xa.add(x);
                    data["wards"].map((v) => {
                        var option = document.createElement("option");
                        option.text = v.name;
                        option.value = v.name;
                        xa.add(option);
                    })
                });

        }
        4
    </script>
</body>

</html>