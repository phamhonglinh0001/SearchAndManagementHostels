<?php
include("autoload.php");
session_start();

if(!isset($_SESSION["TTDN"]["ma_ct"])) header("location: dangnhap.php");
else $ma_ct = $_SESSION["TTDN"]["ma_ct"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $ten_nt = $_POST["ten_nt"];
    $ngay_lap = $_POST["ngay_lap"];
    $mo_ta = $_POST["mo_ta"];
    $noi_quy_nt = $_POST["noi_quy_nt"];
    $xa = $_POST["xa"];
    $huyen = $_POST["huyen"];
    $tinh = $_POST["tinh"];
    $vi_do = $_POST["vi_do"];
    $kinh_do = $_POST["kinh_do"];

    $ma_dc = (new DiaChi)->themDiaChi($xa, $huyen, $tinh, $vi_do, $kinh_do);

    (new NhaTro)->themNhaTro($ten_nt, $ngay_lap, $mo_ta, $noi_quy_nt, $ma_ct, $ma_dc);

    $_SESSION["err"] = "Thêm thành công";
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
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    
    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
</head>

<body
    onload="layTinh()"
>
    <?php
    include("components/navbar.php");
    ?>
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
                        const ds = fetch("https://provinces.open-api.vn/api/p/"+code_tinh+"?depth=2")
                            .then((response) => response.json())
                            .then(data => {
                                huyen.options.length = 0;
                                data["districts"].map((v) => {
                                    var option = document.createElement("option");
                                    option.text = v.name;
                                    option.value = v.name;
                                    option.setAttribute("code", v.code);
                                    huyen.add(option);
                                })
                            });

                    }
                    function layXa(huyen) {
                        const xa = document.getElementById("xa");
                        let code_huyen = $("option:selected", huyen).attr("code");
                        const ds = fetch("https://provinces.open-api.vn/api/d/"+code_huyen+"?depth=2")
                            .then((response) => response.json())
                            .then(data => {
                                xa.options.length = 0;
                                data["wards"].map((v) => {
                                    var option = document.createElement("option");
                                    option.text = v.name;
                                    option.value = v.name;
                                    xa.add(option);
                                })
                            });

                    }
                </script>
    <div class="container mx-auto p-3" style="width: 1000px;">
        <h4 class="text-center">
            Thêm mới nhà trọ
        </h4>
        <div class="text-center">
        <span class="text-danger">
                    <?php if (isset($_SESSION["err"])) {
                        echo $_SESSION["err"];
                        unset($_SESSION["err"]);
                    } ?>
                </span>
        </div>
        <form action="" method="post">
        <div class="mx-auto bg-white rounded-3 p-3" style="width: 700px;">
            <input required name="ten_nt" type="text" class="form-control" placeholder="Tên nhà trọ">
            <br>
            <div class="input-group">
                    <span class="input-group-text">Ngày lập</span>
                    <input required id="ngay_lap" name="ngay_lap" type="date" class="form-control" placeholder="Ngày sinh">
                </div>
                <br>
            <textarea name="mo_ta" type="text" class="form-control" placeholder="Mô tả"></textarea>
            <br>
            <textarea name="noi_quy_nt" type="text" class="form-control" placeholder="Nội quy"></textarea>
            <br>
            <div class="input-group">
                    <span class="input-group-text" style="width: 200px">Thành phố/Tỉnh</span>
                    <select  onchange="layHuyen(this)" class="form-control form-select" id="tinh" name="tinh">
                        
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" style="width: 200px">Quận/Huyện</span>
                    <select onchange="layXa(this)" class="form-control form-select" id="huyen" name="huyen">
                        
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" style="width: 200px">Phường/Xã</span>
                    <select class="form-control form-select" id="xa" name="xa">

                    </select>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" style="width: 200px">Tọa độ Google Map</span>
                    <input required name="vi_do" type="text" class="form-control" placeholder="Vĩ độ">
                    <input required name="kinh_do" type="text" class="form-control" placeholder="Kinh độ">
                </div>
                <br>
        </div>
        <br>
        <div class="text-center">
            <button type="submit" class="btn btn-danger">
                Thêm mới
            </button>
            <a class="btn btn-primary" href="quanlynhatro.php">
                Trở về
            </a>
        </div>
        </form>
    </div>
</body>

</html>