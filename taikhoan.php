<?php
include("autoload.php");
session_start();
if (!isset($_SESSION["TTDN"])) {
    $_SESSION["dieuhuong"] = "taikhoan.php";
    header("location: dangnhap.php");
} else {
    $ma_tk = $_SESSION["TTDN"]["MSTK"];
    $loai_tk = $_SESSION["TTDN"]["loai_tk"];
    if (isset($_SESSION["TTDN"]["ma_ct"])) $ma_ct = $_SESSION["TTDN"]["ma_ct"];
    if (isset($_SESSION["TTDN"]["ma_kt"])) $ma_kt = $_SESSION["TTDN"]["ma_kt"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hovaten = $_POST["hovaten"];
    $gioitinh = $_POST["gioitinh"];
    $sdt = $_POST["sdt"];
    $email = $_POST["email"];
    $tinh = $_POST["tinh"];
    $huyen = $_POST["huyen"];
    $xa = $_POST["xa"];
    $ngaysinh = $_POST["ngaysinh"];


    if (
        (new TaiKhoan)->kiemTraSDTVaEmail($sdt, $email, $ma_tk)
    ) $_SESSION["err"] = (new TaiKhoan)->kiemTraSDTVaEmail($sdt, $email, $ma_tk);
    else {

        if ($loai_tk == "chutro") (new ChuTro)->capNhatTen($hovaten, $ma_ct);
        if ($loai_tk == "khachtro") {
            $bien_so_xe = $_POST["bien_so_xe"];
            $so_cccd = $_POST["so_cccd"];
            (new KhachTro)->capNhat($hovaten, $so_cccd, $bien_so_xe, $ma_tk);
        }
        $ma_ttcn = (new TaiKhoan)->layMaTTCN($ma_tk);

        (new ThongTinCN)->capNhatTTCN($ngaysinh, $gioitinh, $sdt, $email, $ma_ttcn);

        $ma_qq =  (new ThongTinCN)->layMaDc($ma_ttcn);

        (new DiaChi)->capNhat($xa, $huyen, $tinh, $ma_qq);


        if (isset($_FILES["anhdaidien"]) && $_FILES["anhdaidien"]["error"] != 4) {
            $tenfile = $_FILES["anhdaidien"]["name"];
            $arr = explode(".", $tenfile);
            $temp = end($arr);



            $dir = "./assets/img/anhdaidien/" . $ma_tk . "." . $temp;
            if (file_exists($dir)) unlink($dir);
            move_uploaded_file($_FILES["anhdaidien"]["tmp_name"], $dir);
            (new Taikhoan)->capNhatAVT($ma_tk, $ma_tk . "." . $temp);
        }



        $_SESSION["err"] = "Cập nhật thành công";
    }
}

$ttcn = (new ThongTinCN)->layTTCN($ma_tk, $loai_tk);

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">


    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
</head>

<body onload="layTinh()">
    <?php
    include("components/navbar.php");
    ?>
    <div class="container mx-auto p-4" style="min-width: 800px">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-7 p-2">
                    <h3 class="text-center">Thông tin cá nhân</h3>
                    <div class="text-center">
                        <span class="text-danger">
                            <?php if (isset($_SESSION["err"])) {
                                echo $_SESSION["err"];
                                unset($_SESSION["err"]);
                            } ?>
                        </span>
                    </div>

                    <div class="table-responsive rounded-3 bg-white p-3">
                        <table class="table table-borderless">
                            <tr>
                                <th class="text-end" style="width: 30%;">
                                    Họ và tên
                                </th>
                                <td>
                                    <input name="hovaten" type="text" class="form-control" <?php
                                                                                            if (isset($ttcn["ten_kt"])) echo 'value="' . $ttcn["ten_kt"] . '"';
                                                                                            if (isset($ttcn["ten_ct"])) echo 'value="' . $ttcn["ten_ct"] . '"';

                                                                                            ?>>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">
                                    Ngày sinh
                                </th>
                                <td>
                                    <input name="ngaysinh" type="date" class="form-control" <?php
                                                                                            if (isset($ttcn["ngay_sinh"])) echo 'value="' . $ttcn["ngay_sinh"] . '"';
                                                                                            ?>>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">
                                    Giới tính
                                </th>
                                <td>
                                    <select class="form-select" name="gioitinh">
                                        <option value="nam" <?php if ($ttcn["gioi_tinh"] == "nam") echo "selected"; ?>>Nam</option>
                                        <option value="nu" <?php if ($ttcn["gioi_tinh"] == "nu") echo "selected"; ?>>Nữ</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">
                                    Số điện thoại
                                </th>
                                <td>
                                    <input name="sdt" type="text" class="form-control" <?php if (isset($ttcn["sdt"])) echo 'value="' . $ttcn["sdt"] . '"'; ?>>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">
                                    Email
                                </th>
                                <td>
                                    <input name="email" type="text" class="form-control" <?php if (isset($ttcn["email"])) echo 'value="' . $ttcn["email"] . '"'; ?>>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end">
                                    Quê quán
                                </th>
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
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text" style="width: 150px">Thành phố/Tỉnh</span>
                                        <select onchange="layHuyen(this)" class="form-control form-select" id="tinh" name="tinh">
                                            <option value="<?php if (isset($ttcn["tinh"])) echo $ttcn["tinh"]; ?>">
                                                <?php if (isset($ttcn["tinh"])) echo $ttcn["tinh"]; ?>
                                            </option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-text" style="width: 150px">Quận/Huyện</span>
                                        <select onchange="layXa(this)" class="form-control form-select" id="huyen" name="huyen">
                                            <option value="<?php if (isset($ttcn["huyen"])) echo $ttcn["huyen"]; ?>">
                                                <?php if (isset($ttcn["huyen"])) echo $ttcn["huyen"]; ?>
                                            </option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-text" style="width: 150px">Phường/Xã</span>
                                        <select class="form-control form-select" id="xa" name="xa">
                                            <option value="<?php if (isset($ttcn["xa"])) echo $ttcn["xa"]; ?>">
                                                <?php if (isset($ttcn["xa"])) echo $ttcn["xa"]; ?>
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <?php if ($loai_tk == "khachtro") echo '
                        <tr>
                            <th class="text-end">
                                Biển số xe
                            </th>
                            <td>
                            <input name="bien_so_xe" type="text" class="form-control" value="' . (isset($ttcn["bien_so_xe"]) ? $ttcn["bien_so_xe"] : "") . '">
                            </td>
                        </tr>
                        <tr>
                            <th class="text-end">
                                Căn cước công dân
                            </th>
                            <td>
                            <input name="so_cccd" type="text" class="form-control" value="' . (isset($ttcn["so_cccd"]) ? $ttcn["so_cccd"] : "") . '">
                            </td>
                        </tr>
                        ';
                            ?>
                        </table>
                    </div>
                </div>
                <div class="col-5 p-2">
                    <h3 class="text-center">Ảnh đại diện</h3>
                    <div class="d-flex justify-content-center algin-items-center">

                        <img style="width:200px; height: 200px; border-radius: 50%;" src="assets/img/anhdaidien/<?php
                                                                                                                if ((new TaiKhoan)->layAVT($ma_tk)) echo (new TaiKhoan)->layAVT($ma_tk);
                                                                                                                else {
                                                                                                                    if ((new TaiKhoan)->layGT($ma_tk) == "nam") echo "macdinh_nam.png";
                                                                                                                    else echo "macdinh_nu.png";
                                                                                                                }
                                                                                                                ?>">

                    </div>
                    <div class="my-3 mx-auto" style="width: 70%;">
                        <input accept="image/*" class="form-control" name="anhdaidien" type="file" id="formFile">
                    </div>
                </div>

            </div>
            <div class="text-center pt-2">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
    </div>
    </form>
    </div>
</body>

</html>