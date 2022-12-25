<?php
include("autoload.php");
session_start();
// print_r($_SESSION["TTDN"]);

if (isset($_POST["tendangnhap"]) && isset($_POST["matkhau"])) {
    $tdn = $_POST["tendangnhap"];
    // $loaiTk = $_POST["loaitaikhoan"];
    $mk = md5($_POST["matkhau"]);
    $ma_tk = "";
    $loaiTk = "";
    $data = (new TaiKhoan)->layMaTK($tdn, $mk);
    if($data) {
    $ma_tk = $data["ma_tk"];
    $loaiTk = $data["loai_tk"];
        }
    if (
        !$ma_tk
    ) $_SESSION["err"] = "Tên tài khoản hoặc mật khẩu sai";
    else {
        
        if($loaiTk=="khachtro"){

            $_SESSION["TTDN"] = [
                "loai_tk" => $loaiTk,
                "MSTK" => $ma_tk,
                "ma_kt" => (new TaiKhoan)->layMaKt($ma_tk)
            ];

        }else
        if($loaiTk=="chutro"){

            $_SESSION["TTDN"] = [
                "loai_tk" => $loaiTk,
                "MSTK" => $ma_tk,
                "ma_ct" => (new TaiKhoan)->layMaCt($ma_tk)
            ];

        }
        
        if (isset($_SESSION["dieuhuong"])) {
            $dh = $_SESSION["dieuhuong"];
            unset($_SESSION["dieuhuong"]);
            header("location:" . $dh);
        } else {
            if($loaiTk=="chutro") header("location:quanlynhatro.php");
            if($loaiTk=="khachtro") header("location:chitietotro.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
</head>

<body
    style="
        background-image: linear-gradient(45deg, #fbc2eb 0%, #a6c1ee 100%);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        min-height: 100vh;
    "
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
                            ĐĂNG NHẬP
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
                <input required name="tendangnhap" type="text" class="form-control" placeholder="Tên đăng nhập">
                <br>
                <input required name="matkhau" type="password" class="form-control" placeholder="Mật khẩu">
                <br>
                <input class="bg-primary" type="submit" value="Đăng nhập" style="border: none; width: 100%;color: white; padding: 7px;">
                <!-- <br><br>
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
                <br> -->
                <br><br>
                <div class="text-end">
                    <a href="dangky.php" class="link-warning">

                        Đăng ký

                    </a>
                </div>
            </form>

        </div>
    </div>
</body>

</html>