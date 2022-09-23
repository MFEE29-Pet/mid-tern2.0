<?php require __DIR__ . '/parts/goods_connect_db.php';
$pageName = 'base';
?>

<?php include __DIR__ . '/parts/goods_part_head.php' ?>

<?php include __DIR__ . '/parts/goods_part_nav.php' ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <img src="./pics/狗罐頭和鮮食/狗罐頭1.png" class="card-img-top" alt="..." height="450">
                <div class="card-body">
                    <h5 class="card-title">寵物食品</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                        the
                        card's content.</p>
                    <a href="#" class="btn btn-primary">寵物食品</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <img src="./pics/貓用品/貓用品1.png" class="card-img-top" alt="..." height="450">
                <div class="card-body">
                    <h5 class="card-title">寵物日用品</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                        the
                        card's content.</p>
                    <a href="#" class="btn btn-primary">寵物日用品</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/goods_part_script.php' ?>

<?php include __DIR__ . '/parts/goods_part_foot.php' ?>