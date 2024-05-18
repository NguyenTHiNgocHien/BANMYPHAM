<?php
include_once 'lib/session.php';
Session::checkSession('client');
include_once 'classes/cart.php';
include_once 'classes/user.php';

$cart = new cart();
$list = $cart->get();
$totalPrice = $cart->getTotalPriceByUserId();
$totalQty = $cart->getTotalQtyByUserId();

$user = new user();
$userInfo = $user->get();
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
    <title>Checkout</title>
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
            <li><a href="order.php" id="order">Đơn hàng</a></li>
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
                    <span style="color: #551A8B;" class="sumItem">
                        <?= ($totalQty['total']) ? $totalQty['total'] : "0" ?>
                    </span>
                </a>
            </li>
                    </ul>

                </div>
            </div>     
        </div>
    </section>
    <section class="sliders"></section>
    <section class="product-container"></section>
    <div class="featuredProducts">
        <h1>Giỏ hàng</h1>
    </div>
    <div class="container-single">
        <?php
        if ($list) { ?>
            <table class="order">
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thao tác</th>
                </tr>
                <?php
                $count = 1;
                foreach ($list as $key => $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['productName'] ?></td>
                        <td><img class="image-cart" src="admin/uploads/<?= $value['productImage'] ?>"></td>
                        <td><?= number_format($value['productPrice'], 0, '', ',') ?>VND </td>
                        <td>
                            <input id="<?= $value['productId'] ?>" type="number" name="qty" class="qty" value="<?= $value['qty'] ?>" onchange="update(this)" min="1">
                        </td>
                        <td>
                            <a href="delete_cart.php?id=<?= $value['id'] ?>">Xóa</a>
                        </td>
                    </tr>
                <?php }
                ?>
            </table>
            <div class="orderinfo">
                <div class="buy">
                    <h3>Thông Tin Đơn Hàng</h3>
                    <div>
                        <b>Người đặt hàng:</b><br> <?= $userInfo['fullname'] ?>
                    </div>
                    <div>
                        <b>Số lượng:</b>  <id="qtycart"><?= $totalQty['total'] ?>
                    </div>
                    <div>
                        <b>Tổng tiền:</b>  <id="totalcart"><?= number_format($totalPrice['total'], 0, '', ',') ?>VND
                    </div>
                    <div>
                        <b>Địa chỉ nhận hàng:</b> <br><?= $userInfo['address'] ?>
                    </div>
                    <div>
                        <select name="phuongthuc"> 
                        <option value = "1"> Thanh toán  </option>
                        <option value = "2"> Thanh toán trực tiếp </option>
                        <option value = "3"> Chuyển Khoản </option>
                        </select>
                    </div>
                    <div class="buy-btn">
                        <a href="add_order.php">Tiến hành đặt hàng</a>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <h3>Giỏ hàng hiện đang rỗng</h3>
        <?php }
        ?>
    </div>
    </div>
    <footer>
        <div class="social">
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        </div>
        <ul class="list">
            
        </ul>
        <p class="copyright">
            <li>   Địa chỉ: Số 23 Đường Cát Bi , Thành Tô , Hải An Hải Phòng </li>
                    <li>Điện thoại: 028 6680 4323 -  Hotline:  0935 051 068 </li>
                    <li>Email:  admin@gmail.com</li>
            
        </p>
    </footer>
</body>
<script type="text/javascript">
    function update(e) {
        var http = new XMLHttpRequest();
        var url = 'update_cart.php';
        var params = "productId=" + e.id + "&qty=" + e.value;
        http.open('POST', url, true);

        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        http.onreadystatechange = function() {
            if (http.readyState === XMLHttpRequest.DONE) {
                var status = http.status;
                if (status === 200) {
                    var arr = http.responseText;
                    var b = false;
                    var result = "";
                    for (let index = 0; index < arr.length; index++) {
                        if (arr[index] == "[") {
                            b = true;
                        }
                        if (b) {
                            result += arr[index];
                        }
                    }
                    var arrResult = JSON.parse(result.replace("undefined", ""));
                    console.log(arrResult);
                    document.getElementById("totalQtyHeader").innerHTML = arrResult[1]['total'];
                    document.getElementById("qtycart").innerHTML = arrResult[1]['total'];
                    document.getElementById("totalcart").innerHTML = arrResult[0]['total'].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + "VND";

                    //alert('Đã cập nhật giỏ hàng!');
                } else if (status === 501) {
                    alert('Số lượng sản phẩm không đủ để thêm vào giỏ hàng!');
                    e.value = parseInt(e.value) - 1;
                } else {
                    alert('Cập nhật giỏ hàng thất bại!');
                    window.location.reload();
                }
            }

        }
        http.send(params);
    }

    var list = document.getElementsByClassName("qty");
    for (let item of list) {
        item.addEventListener("keypress", function(evt) {
            evt.preventDefault();
        });
    }
</script>

</html>