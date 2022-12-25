<?php
include("autoload.php");
session_start();

if(!isset($_SESSION["TTDN"]["ma_ct"])) header("location: dangnhap.php");
else $ma_ct = $_SESSION["TTDN"]["ma_ct"];

$ma_nt = $_GET["id"];

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

    (new DiaChi)->capNhat($xa, $huyen, $tinh,$ma_nt, $vi_do, $kinh_do);

    (new NhaTro)->capNhatNhaTro($ma_nt, $ten_nt, $ngay_lap, $mo_ta, $noi_quy_nt);

    $_SESSION["err"] = "Cập nhật thành công";

}
    $nt = (new NhaTro)->layNhaTro($ma_nt);
    $ma_dc = $nt["ma_dc"];
    $dc = (new DiaChi)->layDiaChi($ma_dc);
?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nhà trọ</title>
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
                                    const gt_cu = tinh.value;

                                    const ds = fetch("https://provinces.open-api.vn/api/p/")
                                        .then((response) => response.json())
                                        .then(data => {
                                            tinh.options.length = 0;
                                            data.map((v) => {
                                                var option = document.createElement("option");
                                                option.text = v.name;
                                                option.value = v.name;
                                                option.setAttribute("code", v.code);
                                                if (option.value == gt_cu) {
                                                    option.setAttribute("selected", true);
                                                }
                                                tinh.add(option);
                                            });
                                            const huyen = document.getElementById("huyen");
                                            const ma_tinh = $("option:selected", tinh).attr("code");
                                            const huyen_cu = huyen.value;
                                            const ds = fetch("https://provinces.open-api.vn/api/p/" + ma_tinh + "?depth=2")
                                                .then((response) => response.json())
                                                .then(data => {
                                                    huyen.options.length = 0;
                                                    data["districts"].map((v) => {
                                                        var option = document.createElement("option");
                                                        option.text = v.name;
                                                        option.value = v.name;
                                                        option.setAttribute("code", v.code);
                                                        if (option.value == huyen_cu) {
                                                            option.setAttribute("selected", true);
                                                        }
                                                        huyen.add(option);
                                                    })
                                                    const xa = document.getElementById("xa");
                                                    let code_huyen = $("option:selected", huyen).attr("code");
                                                    const xa_cu = xa.value;
                                                    const ds = fetch("https://provinces.open-api.vn/api/d/" + code_huyen + "?depth=2")
                                                        .then((response) => response.json())
                                                        .then(data => {
                                                            xa.options.length = 0;
                                                            data["wards"].map((v) => {
                                                                var option = document.createElement("option");
                                                                option.text = v.name;
                                                                option.value = v.name;
                                                                if (option.value == xa_cu) {
                                                                    option.setAttribute("selected", true);
                                                                }
                                                                xa.add(option);
                                                            })
                                                        });

                                                });
                                        });
                                }

                                function layHuyen(tinh) {
                                    const huyen = document.getElementById("huyen");
                                    let code_tinh = $("option:selected", tinh).attr("code");
                                    const ds = fetch("https://provinces.open-api.vn/api/p/" + code_tinh + "?depth=2")
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
                                    const ds = fetch("https://provinces.open-api.vn/api/d/" + code_huyen + "?depth=2")
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
            Sửa nhà trọ
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
        <div class="mx-auto p-3 rounded-3 bg-white" style="width: 700px;">
            <input required name="ten_nt" type="text" class="form-control" placeholder="Tên nhà trọ"
            <?php if (isset($nt["ten_nt"])) echo 'value="' . $nt["ten_nt"] . '"';?>
            >
            <br>
            <div class="input-group">
                    <span class="input-group-text">Ngày lập</span>
                    <input required id="ngay_lap" name="ngay_lap" type="date" class="form-control" placeholder="Ngày sinh"
                    <?php if (isset($nt["ngay_lap"])) echo 'value="' . $nt["ngay_lap"] . '"';?>
                    >
                </div>
                <br>
            <textarea name="mo_ta" type="text" class="form-control" placeholder="Mô tả"><?php 
            if (isset($nt["mo_ta"])) echo $nt["mo_ta"];
            ?></textarea>
            <br>
            <textarea name="noi_quy_nt" type="text" class="form-control" placeholder="Nội quy"><?php 
            if (isset($nt["noi_quy_nt"])) echo $nt["noi_quy_nt"];
            ?></textarea>
            <br>
            <div class="input-group">
                    <span class="input-group-text" style="width: 200px">Thành phố/Tỉnh</span>
                    <select  onchange="layHuyen(this)" class="form-control form-select" id="tinh" name="tinh">
                    <option value="<?php if (isset($dc["tinh"])) echo $dc["tinh"]; ?>">
                                            <?php if (isset($dc["tinh"])) echo $dc["tinh"]; ?>
                                        </option>
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" style="width: 200px">Quận/Huyện</span>
                    <select onchange="layXa(this)" class="form-control form-select" id="huyen" name="huyen">
                    <option value="<?php if (isset($dc["huyen"])) echo $dc["huyen"]; ?>">
                                            <?php if (isset($dc["huyen"])) echo $dc["huyen"]; ?>
                                        </option>
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" style="width: 200px">Phường/Xã</span>
                    <select class="form-control form-select" id="xa" name="xa">
                    <option value="<?php if (isset($dc["xa"])) echo $dc["xa"]; ?>">
                                            <?php if (isset($dc["xa"])) echo $dc["xa"]; ?>
                                        </option>
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" style="width: 200px">Tọa độ Google Map</span>
                    <input required name="vi_do" type="text" class="form-control" placeholder="Vĩ độ"
                    value="<?php if (isset($dc["vi_do"])) echo $dc["vi_do"];?>"
                    >
                    <input required name="kinh_do" type="text" class="form-control" placeholder="Kinh độ"
                    value="<?php if (isset($dc["kinh_do"])) echo $dc["kinh_do"];?>"
                    >
                </div>
                <br>
        </div>
        <br>
        <div class="text-center">
            <button type="submit" class="btn btn-danger">
            <i class="fas fa-check-circle"></i>
                Lưu thay đổi
            </button>
            <a class="btn btn-primary" href="quanlynhatro.php">
            <i class="fas fa-undo"></i>
                Trở về
            </a>
        </div>
        </form>
    </div>
</body>

</html>