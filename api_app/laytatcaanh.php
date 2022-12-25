<?php
    header('Content-Type: application/json; charset=utf-8');
    include("../autoload.php");
    
    $ma_pt = $_GET["ma_pt"];

    $data = (new AnhPt)->layAllAnh($ma_pt);

    if($data) {
        echo json_encode($data);
    }else{
        echo json_encode(array(array("ten_apt"=>"macdinh.jpg")));
    }
?>