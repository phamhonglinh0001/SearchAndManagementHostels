<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand">
            <i class="fas fa-home"></i>
            BeeHome
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                
                <?php
                if(!isset($_SESSION["TTDN"])||!isset($_SESSION["TTDN"]["ma_ct"])){
                    echo 
                    '
                    <li class="nav-item">
                    <a class="nav-link" href="timkiemphongtro.php">
                        <i class="fas fa-search"></i>
                        Tìm phòng trọ
                    </a>
                </li>
                    ';
                }
                if (isset($_SESSION["TTDN"]["loai_tk"]))
                    if ($_SESSION["TTDN"]["loai_tk"] == "chutro"){
                        echo '
                        <li class="nav-item">
                        <a class="nav-link" href="quanlynhatro.php">
                            <i class="fas fa-tasks"></i>
                            Quản lý nhà trọ
                        </a>
                        </li>
                        ';
                        echo '
                        <li class="nav-item">
                        <a class="nav-link" href="yeucauthamgia.php">
                        <i class="fas fa-paper-plane"></i>
                            Yêu cầu tham gia
                        </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="tinnhan_ct.php">
                            <i class="fas fa-comments"></i>
                                Tin nhắn
                            </a>
                        </li>
                        ';
                    }
                    
                ?>
                <?php
                if (isset($_SESSION["TTDN"]["loai_tk"]))
                    if ($_SESSION["TTDN"]["loai_tk"] == "khachtro"){
                        echo '
                    <li class="nav-item">
                    <a class="nav-link" href="chitietotro.php">
                        <i class="fas fa-info-circle"></i>
                        Chi tiết ở trọ
                    </a>
                    </li>
                    ';

                        echo '
                    <li class="nav-item">
                    <a class="nav-link" href="daluu.php">
                        <i class="fas fa-save"></i>
                        Đã lưu
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="tinnhan_kt.php">
                    <i class="fas fa-comments"></i>
                        Tin nhắn
                    </a>
                    </li>
                    ';
                    }
                    
                ?>
                <?php
                if (!isset($_SESSION["TTDN"]))
                    echo '
                    <li class="nav-item">
                    <a class="nav-link" href="dangnhap.php">
                        <i class="fas fa-sign-in"></i>
                        Đăng nhập
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="dangky.php">
                        <i class="fas fa-user-plus"></i>
                        Đăng ký
                    </a>
                    </li>
                    ';
                else
                    echo '
                    <li class="nav-item dropdown float-end">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        Tài khoản
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="taikhoan.php">
                                <i class="fas fa-address-card"></i>
                                Thông tin
                            </a></li>
                        <li><a class="dropdown-item" href="dangxuat.php">
                                <i class="fas fa-sign-out"></i>
                                Đăng xuất
                            </a></li>
                    </ul>
                    </li>
                    ';

                ?>
                
                
            </ul>
        </div>
    </div>
</nav>