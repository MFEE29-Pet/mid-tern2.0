<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<style>
    nav.navbar .nav-item .nav-link.active {
        border-radius: 5px;
        background-color: #00f;
        color: #fff;
        font-weight: 800;
    }
</style>

<div class="container">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">商品管理</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'base' ? 'active' : '' ?>" href="2_goods_basepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'list' ? 'active' : '' ?>" href="2_goods_product_list.php">商品列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $pageName == 'insert' ? 'active' : '' ?>" href="2_goods_insert_form.php">新增</a>
                    </li>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (empty($_SESSION['user1'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="0912_async_login_form.php">登入</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">註冊</a>
                        </li>

                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link">
                                <?= $_SESSION['user1']['nickname'] ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="0912_logout.php">登出</a>
                        </li>
                    <?php endif; ?>

                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</div>