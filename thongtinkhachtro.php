<?php
include("autoload.php");
session_start();
if (isset($_SESSION["TTDN"]["ma_ct"])) {
    $ma_ct = $_SESSION["TTDN"]["ma_ct"];
} else {
    header("location: dangnhap.php");
}

$ma_kt = $_GET["ma_kt"];

$tt_kt = (new KhachTro)->layThongTinKhachTro($ma_kt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách trọ</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
</head>

<body>
    <div class="container p-4">
        <div class="row d-flex justify-content-start align-items-center flex-wrap">
            <div class="mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <?php
                            if($tt_kt["anh_dai_dien"]) $avt = $tt_kt["anh_dai_dien"];
                            else if($tt_kt["gioi_tinh"]=="nam") $avt = "macdinh_nam.png";
                            else $avt = "macdinh_nu.png";
                        ?>
                        <div class="col-md-4 text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;
                                        background-image: linear-gradient(to right, #b8cbb8 0%, #b8cbb8 0%, #b465da 0%, #cf6cc9 33%, #ee609c 66%, #ee609c 100%);
                                    ">
                            <img src="assets/img/anhdaidien/<?php echo $avt; ?>" alt="Avatar" class="img-fluid my-5" style="width: 150px;height: 150px;border-radius: 50%;" />
                            <h5><?php if($tt_kt["ten_kt"]) echo $tt_kt["ten_kt"]; ?></h5>
                            <p><?php if($tt_kt["ngay_sinh"]) echo $tt_kt["ngay_sinh"]; ?></p>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6>Thông tin</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-0">
                                        <h6>Biển số xe</h6>
                                        <p class="text-muted"><?php if($tt_kt["bien_so_xe"]) echo $tt_kt["bien_so_xe"]; ?></p>
                                    </div>
                                    <div class="col-6 mb-0">
                                        <h6>Căn cước công dân</h6>
                                        <p class="text-muted"><?php if($tt_kt["so_cccd"]) echo $tt_kt["so_cccd"]; ?></p>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-6 mb-0">
                                        <h6>Email</h6>
                                        <p class="text-muted"><?php if($tt_kt["email"]) echo $tt_kt["email"]; ?></p>
                                    </div>
                                    <div class="col-6 mb-0">
                                        <h6>Số điện thoại</h6>
                                        <p class="text-muted"><?php if($tt_kt["sdt"]) echo $tt_kt["sdt"]; ?></p>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col mb-0">
                                        <h6>Địa chỉ</h6>
                                        <p class="text-muted"><?php echo $tt_kt["xa"].', '.$tt_kt["huyen"].', '.$tt_kt["tinh"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>