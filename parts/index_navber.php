<?php
if (!isset($_SESSION)) {
  session_start();
}
?>

<body>
  <main class="main">
    <header class="p-3 text-white">
      <div class="header-box">
        <!-- <div class="menu-btn">
            <i class="fa-solid fa-bars "></i>
          </div> -->
        <ul class="nav mb-2 justify-content-start mb-md-0">
          <li>
            <a href="5_index_page.php" class="nav-link px-4">
              <img src="./images/logo_white.png" alt="">
            </a>
          </li>

        </ul>
        <div class="text-end">
          <!-- <button type="button" class="btn btn-nickname"> -->
          <?php if (!empty($_SESSION['admin'])) : ?>
            <a class="btn btn-primary disable" href="#"><?= $_SESSION['admin']['nickname'] ?></a>
            <button type="button" class="btn btn-reg" onclick="outAdmin()">管理者登出
            </button>
          <?php elseif (!empty($_SESSION['user1'])) : ?>
            <a class="btn btn-primary" href="5_logout_api.php"><?= "登出" ?></a>
          <?php endif; ?>

          <!-- </button> -->
          <?php if (empty($_SESSION['admin']) && empty($_SESSION['user1'])) : ?>
            <button type="button" class="btn btn-reg" onclick="loginUser()">會員登入
            </button>
            <button type="button" class="btn btn-reg" onclick="loginAdmin()">管理者登入
            </button>
          <?php endif; ?>

          <?php if (!empty($_SESSION['admin'])) : ?>


          <?php endif; ?>

        </div>
      </div>
    </header>
    <section class="content">
      <div class="side-bar">
        <!-- <div class="close-btn">
        <i class="fa-solid fa-xmark"></i>
      </div> -->
        <div class="menu">
          <div class="item"><a href="#"><i class="fas fa-desktop"></i>Dashboard</a></div>
          <div class="item">
            <a class="sub-btn">
              <i class="fas fa-table"></i>
              寵物論壇
              <i class="fas fa-angle-right dropdown"></i>
            </a>
            <div class="sub-menu">
              <a href="1_basepage.php" class="sub-item">文章列表</a>
              <a href="1_insert-form.php" class="sub-item">新增文章</a>
            </div>
          </div>
          <div class="item">
            <a class="sub-btn">
              <i class="fa-solid fa-store"></i>
              寵物商城
              <i class="fas fa-angle-right dropdown"></i>
            </a>

            <div class="sub-menu">
              <?php if (!empty($_SESSION['admin'])) : ?>
                <a href="2_goods_product_list.php" class="sub-item">商品列表</a>
                <a href="2_goods_insert_form.php" class="sub-item">新增商品</a>
              <?php endif; ?>


              <a href="2_cart_product-list.php" class="sub-item">購物車</a>

            </div>
          </div>
          <?php if (empty($_SESSION['user1'])) : ?>
            <div class="item">
              <a class="sub-btn">
                <i class="fa-solid fa-campground"></i>
                寵物露營
                <i class="fas fa-angle-right dropdown"></i>
              </a>
              <div class="sub-menu">
                <?php if (!empty($_SESSION['admin'])) : ?>
                  <a href="3_background_management.php" class="sub-item">露營資訊管理</a>
                  <a href="3_camping_order.php" class="sub-item">露營預約管理</a>
                  <a href="3_background_management-insert.php" class="sub-item">新增露營資訊</a>
                  <a href="3_order-insert.php" class="sub-item">新增露營預約</a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if (empty($_SESSION['user1'])) : ?>
            <div class="item">
              <a class="sub-btn">
                <i class="fa-solid fa-hospital"></i>
                寵物醫院
                <i class="fas fa-angle-right dropdown"></i>
              </a>
              <div class="sub-menu">
                <?php if (!empty($_SESSION['admin'])) : ?>
                  <a href="4_datalist_clinic.php" class="sub-item">醫院資訊管理</a>
                  <a href="4_datalist_appointment.php" class="sub-item">掛號預約管理</a>
                  <a href="4_insert_form_clinic.php" class="sub-item">新增資院資訊</a>
                  <a href="4_insert_form_appointment.php" class="sub-item">新增掛號預約</a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="item">
            <a class="sub-btn">
              <i class="fa-solid fa-user-gear"></i>
              會員中心
              <i class="fas fa-angle-right dropdown"></i>
            </a>
            <div class="sub-menu">

                <?php if (!empty($_SESSION['user1'])) : ?>
                  <a href="5_member_self_page.php" class="sub-item">會員個人資料管理</a>
                <?php endif; ?>

                <?php if (!empty($_SESSION['admin'])) : ?>
                  <a href="5_member_list_page.php" class="sub-item">會員基本資料管理</a>
                  <a href="5_contact_list_page.php" class="sub-item">會員聯絡資料管理</a>
                  <a href="5_pet_list_page.php" class="sub-item">寵物資料管理</a>
                  <a href="5_member_insert_page.php" class="sub-item">新增會員</a>
                  <a href="5_pet_insert_page.php" class="sub-item">新增寵物</a>
                <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="table-con">
        <div class="table-box">