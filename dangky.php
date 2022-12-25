<?php
include("autoload.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tdn = $_POST["tendangnhap"];
    $loaiTk = $_POST["loaitaikhoan"];
    $mk = md5($_POST["matkhau"]);
    $r_mk = md5($_POST["r_matkhau"]);
    $hovaten = $_POST["hovaten"];
    $gioitinh = $_POST["gioitinh"];
    $sdt = $_POST["sdt"];
    $email = $_POST["email"];
    $tinh = $_POST["tinh"];
    $huyen = $_POST["huyen"];
    $xa = $_POST["xa"];
    $ngaysinh = $_POST["ngaysinh"];

    if (
        $mk != $r_mk
    ) $_SESSION["err"] = "Nhập lại mật khẩu không trùng khớp";
    else
    if (
        (new TaiKhoan)->kiemTraTonTai($tdn, $sdt, $email)
    ) $_SESSION["err"] = (new TaiKhoan)->kiemTraTonTai($tdn, $sdt, $email);
    else {
        (new TaiKhoan)->themTK($tdn, $mk, $loaiTk, $hovaten, $gioitinh, $sdt, $email, $tinh, $huyen, $xa, $ngaysinh);
        $_SESSION["err"] = "Đăng ký thành công";
    }
}

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
</head>

<body style="
        background-image: url('assets/img/dangky.jpg');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        min-height: 100vh;
        background-image: linear-gradient(45deg, #fbc2eb 0%, #a6c1ee 100%);
    "
    onload="layTinh()"
    >
    <?php
    include("components/navbar_non.php");
    ?>

    <div class="mx-auto" style="min-height: 80vh; width: 80%; padding:50px;">
        <div class="mx-auto" style="width: 500px; border-radius: 5px; background-color: white; padding: 20px 40px;">
            <form action="" method="post">
                <div style="height: 100px; text-align: center;">
                    <h3 style="line-height: 150px;">
                        <b class="text-primary" style="font-size: 30px;">
                            ĐĂNG KÝ
                        </b>
                    </h3>
                </div>
                <span class="text-danger">
                    <?php if (isset($_SESSION["err"])) {
                        echo $_SESSION["err"];
                        unset($_SESSION["err"]);
                    } ?>
                </span>
                <br><br>
                <input required name="hovaten" type="text" class="form-control" placeholder="Họ và tên">
                <br>
                <div class="input-group">
                    <span class="input-group-text">Ngày sinh</span>
                    <input required id="ngaysinh" name="ngaysinh" type="date" class="form-control" placeholder="Ngày sinh">
                </div>
                <br>
                <select class="form-select" name="gioitinh">
                    <option value="nam">Nam</option>
                    <option value="nu">Nữ</option>
                </select>
                <br>
                <input required name="sdt" type="text" class="form-control" placeholder="Số điện thoại">
                <br>
                <input required name="email" type="text" class="form-control" placeholder="Email">
                <br>
                <input required name="tendangnhap" type="text" class="form-control" placeholder="Tên đăng nhập">
                <br>
                <input required name="matkhau" type="password" class="form-control" placeholder="Mật khẩu">
                <br>
                <input required name="r_matkhau" type="password" class="form-control" placeholder="Nhập lại mật khẩu">
                <br>
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
                <div class="input-group">
                    <span class="input-group-text" style="width: 150px">Thành phố/Tỉnh</span>
                    <select  onchange="layHuyen(this)" class="form-control form-select" id="tinh" name="tinh">
                        
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" style="width: 150px">Quận/Huyện</span>
                    <select onchange="layXa(this)" class="form-control form-select" id="huyen" name="huyen">
                        
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" style="width: 150px">Phường/Xã</span>
                    <select class="form-control form-select" id="xa" name="xa">

                    </select>
                </div>
                <br>
                <input class="bg-primary" type="submit" value="Đăng ký" style="border: none; width: 100%;color: white; padding: 7px;">
                <br><br>
                <span>Bạn là: &nbsp;&nbsp;</span>
                <div class="form-check d-inline-block">
                    <input type="radio" class="form-check-input" id="khachtro" name="loaitaikhoan" value="khachtro" checked>
                    <label class="form-check-label" for="khachtro">Khách trọ</label>
                </div>
                &nbsp; &nbsp; &nbsp;
                <div class="form-check d-inline-block">
                    <input type="radio" class="form-check-input" id="chutro" name="loaitaikhoan" value="chutro">
                    <label class="form-check-label" for="chutro">Chủ trọ</label>
                </div>
                <br>
                <br>
                <div class="text-end">
                    <a href="dangnhap.php" class="link-warning">

                        Đăng nhập

                    </a>
                </div>
            </form>

        </div>
    </div>
</body>

</html>