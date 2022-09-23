<?php
if (!isset($_SESSION)) {
  session_start();
}
?>

<body>
  <main class="main">
    <header class="p-3 text-white">
      <div class="header-box">
        <img src="./images/logo_white.png" alt="">
        <!-- <div class="menu-btn">
            <i class="fa-solid fa-bars "></i>
          </div> -->
        <ul class="nav mb-2 justify-content-center mb-md-0">
          <li>
            <a href="5_index_page.php" class="nav-link px-4 <?= $pageName == 'indexpage' ? 'active' : '' ?>">Home</a>
          </li>
          <li>
            <a href="5_member_list_page.php" class="nav-link px-4 <?= $pageName == 'listpage' ? 'active' : '' ?>">列表</a>
          </li>
          <li>
            <a href="5_member_insert_page.php" class="nav-link px-4 <?= $pageName == 'insertpage' ? 'active' : '' ?>">新增</a>
          </li>
        </ul>
        <div class="text-end">
          <!-- <button type="button" class="btn btn-nickname"> -->
            <?php if (!empty($_SESSION['admin'])) : ?>
              <a class="btn btn-primary disable" href="#"><?= $_SESSION['admin']['nickname'] ?></a>
            <?php else :?>
              <a class="btn btn-primary" href="5_login_page.php"><?= "管理者登入" ?></a>
            
            <?php endif; ?>
          <!-- </button> -->
          
            <?php if (!empty($_SESSION['admin'])) : ?>
              <button type="button" class="btn btn-reg" onclick="outAdmin()" >管理者登出
              </button>
            
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
              論壇管理
              <i class="fas fa-angle-right dropdown"></i>
            </a>
            <div class="sub-menu">
              <a href="1_forum-list.php" class="sub-item">文章列表</a>
              <a href="1_insert-form.php" class="sub-item">新增文章</a>
            </div>
          </div>
          <div class="item">
            <a class="sub-btn">
              <i class="fa-solid fa-store"></i>
              Store
              <i class="fas fa-angle-right dropdown"></i>
            </a>
            <div class="sub-menu">
              <a href="#" class="sub-item">Sub Item 01</a>
              <a href="#" class="sub-item">Sub Item 02</a>
              <a href="#" class="sub-item">Sub Item 03</a>
            </div>
          </div>
          <div class="item">
            <a class="sub-btn">
              <i class="fa-solid fa-campground"></i>
              Camping
              <i class="fas fa-angle-right dropdown"></i>
            </a>
            <div class="sub-menu">
              <a href="#" class="sub-item">Sub Item 01</a>
              <a href="#" class="sub-item">Sub Item 02</a>
            </div>
          </div>
          <div class="item">
            <a class="sub-btn">
              <i class="fa-solid fa-hospital"></i>
              Hospital
              <i class="fas fa-angle-right dropdown"></i>
            </a>
            <div class="sub-menu">
              <a href="#" class="sub-item">Sub Item 01</a>
              <a href="#" class="sub-item">Sub Item 02</a>
            </div>
          </div>
          <div class="item">
            <a class="sub-btn">
              <i class="fa-solid fa-user-gear"></i>
              會員管理
              <i class="fas fa-angle-right dropdown"></i>
            </a>
            <div class="sub-menu">
              <a href="5_member_list_page.php" class="sub-item">會員基本資料管理</a>
              <a href="5_contact_list_page.php" class="sub-item">會員聯絡資料管理</a>
              <a href="5_pet_list_page.php" class="sub-item">寵物資料管理</a>
              <a href="5_member_insert_page.php" class="sub-item">新增會員</a>
              <a href="5_pet_insert_page.php" class="sub-item">新增寵物</a>
            </div>
          </div>
        </div>
      </div>
      <div class="table-con">