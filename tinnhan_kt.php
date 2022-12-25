<?php
include("autoload.php");
session_start();

if (isset($_SESSION["TTDN"]["ma_kt"])) {
    $ma_kt = $_SESSION["TTDN"]["ma_kt"];
}
$ma_nt = (new KhachTro)->layMaNhaTro($ma_kt);
if (!$ma_nt) $ma_nt = 0;

$co_o_tro = (new KhachTro)->layNhaTro($ma_kt);

?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin nhắn</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="assets/jquery/jquery.js"></script>
</head>

<body onload="loadMess()">
    <script>
        function getMess() {
            console.log("running");
            const link = "http://localhost/lv/tinnhan_kt_api.php";
            const listMess = document.getElementsByClassName("mess");
            // console.log(listMess);
            if (listMess.length != 0) {
                const maxMess = listMess[listMess.length - 1];
                var max = maxMess.getAttribute("ma_tn");
            } else {
                var max = 0;
            }

            const ma_nt = document.getElementById("tinnhan").getAttribute("ma_nt");
            const ma_kt = document.getElementById("tinnhan").getAttribute("ma_kt");

            // console.log(ma_nt, max, link);
            fetch(link + "?ma_nt=" + ma_nt + "&max=" + max)
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data);
                    setMess(data);
                });

        }

        function setMess(data) {
            const container = document.getElementById("tinnhan");
            const ma_kt = document.getElementById("tinnhan").getAttribute("ma_kt");
            if (!data.errors)
                data.map((value) => {
                    const containerDiv = document.createElement("li");
                    containerDiv.className = "d-flex justify-content-between mb-4";

                    var avt = undefined;
                    if (value.anh_dai_dien) avt = value.anh_dai_dien;
                    else if (value.gioi_tinh == "nam") avt = "macdinh_nam.png";
                    else if (value.gioi_tinh == "nu") avt = "macdinh_nu.png";
                    else avt = "home.png";

                    if (value.ma_kt == ma_kt)
                        containerDiv.innerHTML = `
                            <div class="card w-100">
                                <div class="card-header d-flex justify-content-between py-2 px-4">
                                    <p class="fw-bold mb-0">${value.ten_kt}</p>
                                    <p class="text-muted small mb-0"><i class="far fa-clock me-1"></i>${value.moc_thoi_gian_nhan}</p>
                                </div>
                                <div class="card-body mess" ma_tn="${value.ma_tn}">
                                    <p class="mb-0">
                                        <pre>${value.noi_dung_tn}</pre>
                                    </p>
                                </div>
                            </div>
                            <img src="assets/img/anhdaidien/${avt}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60px" height="60px">
                        `;
                    else
                        containerDiv.innerHTML = `
                            <img src="assets/img/anhdaidien/${avt}" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60px" height="60px">
                        
                            <div class="card w-100">
                                <div class="card-header d-flex justify-content-between py-2 px-4">
                                    <p class="fw-bold mb-0">${value.ten_kt||value.ten_nt}</p>
                                    <p class="text-muted small mb-0"><i class="far fa-clock me-1"></i>${value.moc_thoi_gian_nhan}</p>
                                </div>
                                <div class="card-body mess" ma_tn="${value.ma_tn}">
                                    <p class="mb-0">
                                        <pre>${value.noi_dung_tn}</pre>
                                    </p>
                                </div>
                            </div>
                        `;

                    container.appendChild(containerDiv);
                    containerDiv.scrollIntoView();
                })
        }

        function loadMess() {
            getMess();
            setInterval(getMess, 1000);
        }
    </script>
    <?php
    include("components/navbar.php");
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 p-3">
                <div class="d-flex rounded-3 flex-column flex-shrink-0 p-3 bg-light">

                    <ul class="nav nav-pills flex-column mb-auto">

                        <?php 
                            if($co_o_tro)
                            echo '
                            <li class="nav-item">
                                <a class="nav-link active">
                                    '.$co_o_tro.'
                                </a>
                            </li>
                            ';
                            else 
                            echo '
                            <li class="nav-item">
                                <a class="nav-link active">
                                    Bạn không ở trọ
                                </a>
                            </li>
                            ';
                        ?>
                        
                    </ul>

                </div>
            </div>
            <div class="container col-9 my-1 p-2 mx-auto" style="width: 750px;">

                <div class="row">

                    <div class="p-3">
                        <?php
                            if($co_o_tro) 
                            echo '
                            <div class="p-3 rounded-3" style="height: 330px; overflow-y: auto;
                            background-image: linear-gradient(to left, #feada6 0%, #f5efef 100%);"
                        >
                            <ul id="tinnhan" class="list-unstyled" ma_nt="' . $ma_nt . '" ma_kt="' . $ma_kt . '">
                                
                            </ul>
                        </div>

                        <div class="mt-3">
                            <textarea placeholder="Nhập tin nhắn" class="form-control" name="tn_nhap" id="tn_nhap" rows="5"></textarea>
                            <button onclick="guiTinNhan()" type="button" class="btn btn-info btn-rounded float-end mt-2">Gửi</button>
                        </div>
                            ';
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        //Gui len server
        function guiTinNhan() {
            const ma_kt = document.getElementById("tinnhan").getAttribute("ma_kt");
            const ma_nt = document.getElementById("tinnhan").getAttribute("ma_nt");
            const noidung = document.getElementById("tn_nhap").value;

            if (noidung !== "" && noidung != null && noidung != undefined) {
                const text = JSON.stringify({
                    ma_kt,
                    ma_nt,
                    noidung
                });
                console.log(text);
                fetch("http://localhost/lv/them_tn.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: text
                }).then(data => data.json()).then(data => console.log(data));
                document.getElementById("tn_nhap").value = "";
            }
        }
    </script>
</body>

</html>