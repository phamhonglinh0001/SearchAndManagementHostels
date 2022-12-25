<?php
session_start();
if(isset($_SESSION["TTDN"])){
    unset($_SESSION["TTDN"]);
    header("location:dangnhap.php");
}else{
    header("location:dangnhap.php");
}

?>