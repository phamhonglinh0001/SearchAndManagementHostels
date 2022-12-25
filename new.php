<?php
include("autoload.php");
session_start();
?>

<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Home</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEY_MAP ?>&callback=myMap"></script>

</head>

<body>
    <?php
    include("components/navbar.php");
    ?>

    <script>
        //Khoi tao Map
        function initialize() {
            //Khai bao cac thuoc tinh
            var mapProp = {
                //Tam ban do, quy dinh boi kinh do va vi do
                center: new google.maps.LatLng(9.807397, 105.778926),
                //set default zoom cua ban do khi duoc load
                zoom: 10,
                //Dinh nghia type
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            //Truyen tham so cho cac thuoc tinh Map cho the div chua Map
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(9.807397, 105.778926),
            });

            marker.setMap(map);
        }
        //   google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    
    <button onclick="initialize()">Click</button>
    <div id="googleMap" style="width:500px;height:380px;">
    </div>
</body>

</html>