<?php
include("autoload.php");
session_start();

$ma_nt = $_GET["ma_nt"];
if (isset($_GET["ma_pt"])) $ma_pt = $_GET["ma_pt"];
$ds_nam = (new ChiTietOTro)->layNam($ma_nt);
if (isset($_GET["nam"])) $nam = $_GET["nam"];
else if (isset($ds_nam[0]["year"])) $nam = $ds_nam[0]["year"];
else $nam = false;

// print_r($nam);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <script src="assets/MDB5/js/mdb.min.js"></script>
    <link rel="stylesheet" href="assets/MDB5/css/mdb.min.css">

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="assets/jquery/jquery.js"></script>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
</head>

<body>
    <script>
        const labels = [
            "Tháng 1",
            "Tháng 2",
            "Tháng 3",
            "Tháng 4",
            "Tháng 5",
            "Tháng 6",
            "Tháng 7",
            "Tháng 8",
            "Tháng 9",
            "Tháng 10",
            "Tháng 11",
            "Tháng 12",
        ];
    </script>
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-3 p-3">
                <div class="d-flex rounded-3 flex-column flex-shrink-0 p-3 bg-light">

                    <ul class="nav nav-pills flex-column mb-auto">

                        <li class="nav-item">
                            <a href="thongke.php?ma_nt=<?php echo $ma_nt ?>" class="nav-link text-warning <?php if(!isset($ma_pt)) echo "active" ?>">
                                Tất cả
                            </a>
                        </li>
                        <?php

                        $ds_pt = (new ChuTro)->laySoPhong($ma_nt);
                        // print_r($ds_pt);
                        if ($ds_pt) {

                            foreach ($ds_pt as $x) {
                                if(isset($ma_pt)) {
                                    if($ma_pt==$x["ma_pt"]) $act = "active";else $act= "";
                                }else $act= "";

                                echo '
                                    <li class="nav-item">
                                        <a href="thongke.php?ma_nt=' . $ma_nt . '&ma_pt=' . $x["ma_pt"] . '" class="nav-link '.$act.'">
                                            Phòng số ' . $x["so_phong"] . '
                                        </a>
                                    </li>
                                    ';
                            }
                        } else {
                            echo '
                                    <li class="nav-item">
                                        <a class="nav-link active">
                                            Không có phòng trọ
                                        </a>
                                    </li>
                                    ';
                        }
                        ?>

                    </ul>

                </div>
            </div>
            <div class="container col-9 my-1 p-2 mx-auto">
               
                <?php
                if ($nam)
                    if (isset($ma_pt)) {

                        echo '
                        <div class="p-3 rounded-3 m-3 bg-white"
                        style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;"
                        >
                            <h5 class="text-center mb-4">'.(new NhaTro)->layTenNhaTro($ma_nt).'</h5>
                            <div class="mt-5">
                            <select id="nam" class="form-control form-select">
                            <option value="-1">Chọn năm</option>
                            ';
                            if ($ds_nam) foreach ($ds_nam as $x) {
                                if ($x["year"] == $nam) $select = "selected";
                                else $select = "";
                                echo '<option ' . $select . ' value="' . $x["year"] . '">' . $x["year"] . '</option>';
                            }
                            echo '
                            </select>
                            <div class="text-center mb-5 mt-2">
                            <button onclick="themNam()" class="btn btn-sm btn-primary">
                                Áp dụng
                            </button>
                            </div>
                    </div>

                <div class="">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
                        
                            ';    
                            $data = (new ThongKe)->thongKePhong($ma_pt, $nam);
                            if ($data) {
                                echo '<script>
                                    const du_lieu=' . json_encode($data) . ';
                                    var dien = [];
                                    var nuoc = [];
                                    var tong = [];
                                    var khach = [];
                                    for(let i=1; i<=12; i++){
                                        let tdien = du_lieu.reduce((total, obj)=>{
                                            if(obj.thang==i) return total + obj.tien_dien;
                                            else return total;
                                        },0)
                                        dien.push(tdien);
                                    }
                                    for(let i=1; i<=12; i++){
                                        let ttong = du_lieu.reduce((total, obj)=>{
                                            if(obj.thang==i) return total + obj.tong_tien;
                                            else return total;
                                        },0)
                                        tong.push(ttong);
                                    }
                                    
                                    for(let i=1; i<=12; i++){
                                        let tnuoc = du_lieu.reduce((total, obj)=>{
                                            if(obj.thang==i) return total + obj.tien_nuoc;
                                            else return total;
                                        },0)
                                        nuoc.push(tnuoc);
                                    }
                                    for(let i=1; i<=12; i++){
                                        let tkhach = du_lieu.reduce((total, obj)=>{
                                            if(obj.thang==i) return total + obj.so_khach;
                                            else return total;
                                        },0)
                                        khach.push(tkhach);
                                    }
                                </script>
                                
                            ';
                                echo
                                "
                            
            <script>
            const config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Tiền điện',
                            backgroundColor: 'rgb(255, 99, 132)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: dien,
                        },
                        {
                            label: 'Tiền nước',
                            backgroundColor: '#0066FF',
                            borderColor: '#0066FF',
                            data: nuoc,
                        },
                        {
                            label: 'Tổng tiền',
                            backgroundColor: '#e47200',
                            borderColor: '#e47200',
                            data: tong,
                        },
                        {
                            label: 'Số khách trọ',
                            backgroundColor: '#7f00ff',
                            borderColor: '#7f00ff',
                            data: khach,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                },
            };
    
            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
    
    
                            </script>";
                            }

                    } else {

                        $phong = (new ThongKe)->soPhong($ma_nt);
                        $danh_gia = (new ThongKe)->danhGia($ma_nt);
                        // print_r($danh_gia);

                        echo '
                        <div class="p-3 rounded-3 m-3 bg-white"
                        style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;"
                        >
                            <h5 class="text-center mb-4">'.(new NhaTro)->layTenNhaTro($ma_nt).'</h5>
                            <div class="table-responsive text-center">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="w-50">
                                            Số lượng phòng
                                        </th>
                                        <th>
                                            Điểm đánh giá
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="d-flex justify-content-center">
                                            <div style="height: 250px; width: 250px;">
                                                <canvas id="soPhong"></canvas>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div style="height: 250px; width: 250px;">
                                                    <canvas id="danhGia"></canvas>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <hr>
                            <div class="mt-5">
                                        <select id="nam" class="form-control form-select">
                                        <option value="-1">Chọn năm</option>
                                        ';
                                        if ($ds_nam) foreach ($ds_nam as $x) {
                                            if ($x["year"] == $nam) $select = "selected";
                                            else $select = "";
                                            echo '<option ' . $select . ' value="' . $x["year"] . '">' . $x["year"] . '</option>';
                                        }
                                        echo '
                                        </select>
                                        <div class="text-center mb-5 mt-2">
                                        <button onclick="themNam()" class="btn btn-sm btn-primary">
                                            Áp dụng
                                        </button>
                                        </div>
                                </div>

                            <div class="">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                        <script>
                            const soPhong = new Chart(
                                document.getElementById("soPhong"),
                                {
                                    type: "pie",
                                    
                                    data: {
                                        labels: [
                                          "Phòng trống",
                                          "Có người"
                                        ],
                                        datasets: [{
                                          label: "Số lượng phòng",
                                          data: [' . $phong["so_phong"] - $phong["co_nguoi"] . ',' . $phong["co_nguoi"] . '],
                                          backgroundColor: [
                                            "rgb(54, 162, 235)",
                                            "rgb(255, 205, 86)"
                                          ],
                                          hoverOffset: 4
                                        }]
                                    },
                                }
                            );
                            const danhGia = new Chart(
                                document.getElementById("danhGia"),
                                {
                                    type: "pie",
                                    data: {
                                        labels: [
                                          "1 sao",
                                          "2 sao",
                                          "3 sao",
                                          "4 sao",
                                          "5 sao",
                                        ],
                                        datasets: [{
                                          label: "Số lượt đánh giá",
                                          data: [
                                            ' . $danh_gia["1"] . ',
                                            ' . $danh_gia["2"] . ',
                                            ' . $danh_gia["3"] . ',
                                            ' . $danh_gia["4"] . ',
                                            ' . $danh_gia["5"] . ',
                                          ],
                                          backgroundColor: [
                                            "rgb(54, 162, 235)",
                                            "rgb(255, 205, 86)",
                                            "rgb(255, 99, 132)",
                                            "#ef6a16",
                                            "#05a48c",
                                          ],
                                          hoverOffset: 4
                                        }]
                                    },
                                }
                            );
                        </script>
                        ';

                       

                        $data = (new ChiTietOTro)->thongKeAll($ma_nt, $nam);
                        if ($data) {
                            echo '<script>
                                const du_lieu=' . json_encode($data) . ';
                                const so_khach=' . json_encode((new ThongKe)->soNguoi($ma_nt, $nam)) . '
                                var dien = [];
                                var nuoc = [];
                                var tong = [];
                                var khach = [];
                                for(let i=1; i<=12; i++){
                                    let tdien = du_lieu.reduce((total, obj)=>{
                                        if(obj.thang==i) return total + obj.tien_dien;
                                        else return total;
                                    },0)
                                    dien.push(tdien);
                                }
                                for(let i=1; i<=12; i++){
                                    let tkhach = so_khach.reduce((total, obj)=>{
                                        if(obj.thang==i) return total + obj.so_khach;
                                        else return total;
                                    },0)
                                    khach.push(tkhach);
                                }
                                for(let i=1; i<=12; i++){
                                    let tnuoc = du_lieu.reduce((total, obj)=>{
                                        if(obj.thang==i) return total + obj.tien_nuoc;
                                        else return total;
                                    },0)
                                    nuoc.push(tnuoc);
                                }
                                for(let i=1; i<=12; i++){
                                    let ttong = du_lieu.reduce((total, obj)=>{
                                        if(obj.thang==i) return total + obj.tong_tien;
                                        else return total;
                                    },0)
                                    tong.push(ttong);
                                }
                            </script>
                            
                        ';
                            echo
                            "
                        
        <script>
        const config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Tiền điện',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: dien,
                    },
                    {
                        label: 'Tiền nước',
                        backgroundColor: '#0066FF',
                        borderColor: '#0066FF',
                        data: nuoc,
                    },
                    {
                        label: 'Tổng tiền',
                        backgroundColor: '#e47200',
                        borderColor: '#e47200',
                        data: tong,
                    },
                    {
                        label: 'Số khách trọ',
                        backgroundColor: '#7f00ff',
                        borderColor: '#7f00ff',
                        data: khach,
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            },
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );


                        </script>";
                        }
                    }
                else {
                    echo '<h5>Chưa có dữ liệu</h5>';
                }
                ?>

            </div>
        </div>
    </div>
    <script> 
        function themNam(){
            const selectElement = document.getElementById("nam");
            const nam = (selectElement.value);

            if(nam!=-1){
                let link = window.location.href;
                const vitri = link.indexOf("&nam=");
                if(vitri<0){
                    window.location=(link+`&nam=${nam}`);
                }else{
                    window.location = (link.replace(/&nam=\d\d\d\d/, "&nam="+nam));
                }
            }
        }
    </script>
</body>

</html>