<?php
include 'classes/user.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new user();
    $result = $user->insert($_POST);
    if ($result == true) {
        $userId = $user->getLastUserId(); 
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://use.fontawesome.com/2145adbb48.js"></script>
    <script src="https://kit.fontawesome.com/a42aeb5b72.js" crossorigin="anonymous"></script>
    <title>Đăng ký</title>
</head>

<body>
    <section class="top">
        <div class="top-container">
            <div class="row">
                <div class="top-logo"><img src="images/logo1.jpg" alt="" width="160px" height="auto"></div>

                <div class="menu">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="productList.php">Sản phẩm</a></li>
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                <li><a href="logout.php" id="signin">Đăng xuất</a></li>
            <?php } else { ?>
                <li><a href="register.php" id="signup">Đăng ký</a></li>
                <li><a href="login.php" id="signin">Đăng nhập</a></li>
            <?php } ?>
            <li><a href="login.php" id="order">Đơn hàng</a></li>
                </div>   
                <div class="top-menu-icons">
                    <ul>
                        <li>
                            <input type="text" placeholder="Tìm kiếm">
                            <i class="fas fa-search"></i>
                        </li>
                    <li>
                <a href="checkout.php">
                    <i class="fa fa-shopping-bag" style="color: #551A8B;"></i>
                    <span style="color: #551A8B;" class="sumItem">0
                    </span>
                </a>
            </li>
                    </ul>

                </div>
            </div>     
        </div>
    </section>
    <section class="sliders"></section>
    <section class="product-container">
    <div class="featuredProducts">
        <h1>Đăng ký</h1>
    </div>
    <div class="container-single">
        <div class="login">
            <form action="register.php" method="post" class="form-login">
                <label for="fullName">Họ tên</label>
                <input type="text" id="fullName" name="fullName" placeholder="Họ tên..." required>

                <label for="email">Email</label>
                <p class="error"><?= !empty($result) ? $result : '' ?></p>
                <input type="email" id="email" name="email" placeholder="Email..." required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">

                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Mật khẩu..." required>

                <label for="repassword">Nhập lại mật khẩu</label>
                <input type="password" id="repassword" name="repassword" required placeholder="Nhập lại mật khẩu..." oninput="check(this)">

                <label for="address">Địa chỉ</label>
                <textarea name="address" id="address" cols="30" rows="5" required></textarea>

                <label for="dob">Ngày sinh</label>
                <input type="date" name="dob" id="dob" required>

                <input type="submit" value="Đăng ký" name="submit">
            </form>
        </div>
    </div>
    </div>
</section>
    <footer>
        <div class="social">
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        </div>
        <ul class="list">
            
        </ul>
        <p class="copyright">
        <li>Địa chỉ: Số 23 Đường Cát Bi , Thành Tô , Hải An Hải Phòng </li>
                    <li>Điện thoại: 028 6680 4323 -  Hotline:  0935 051 068 </li>
                    <li>Email:  admin@gmail.com</li>
        </p>
    </footer>
</body>
<script language='javascript' type='text/javascript'>
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Password Must be Matching.');
        }else{
            input.setCustomValidity('');
        }
    }
</script>
</html>