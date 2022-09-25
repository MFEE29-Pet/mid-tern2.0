<?php require __DIR__ . '/parts/goods_connect_db.php';
$pageName = 'list';

// php內正確註解方式/*  */ 


$perPage = 3;
//設定一頁最多有3筆資料

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//用戶沒選頁數時 把第1頁設成預設顯示的寫法

// http://localhost/php_test/address_book/0913_list.php
// 網址尾巴加上 ?page=2 為前往第幾頁

//算總筆數 不需要欄位名 只需要筆數 所以用PDO::FETCH_NUM
$t_sql = "SELECT COUNT(1) FROM products ";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

//pdo為php data object取資料庫某部分資料用連線接口
//fetch的功能類似下載資料取用

// PDO::FETCH_ASSOC: returns an array indexed by column name as returned in your result set
// 返回一个索引为结果集列名的数组

// PDO::FETCH_BOTH (default): 返回陣列名稱和陣列筆數

// PDO::FETCH_NUM: 返回陣列筆數

$totalPages = ceil($totalRows / $perPage);

$rows = []; //設定城陣列後即使沒有值也回傳陣列

//如果$totalRows有資料
if ($totalRows) {
    if ($page < 1) {
        header('Location: ?page=1');  //?page=1前面路徑省略代表為同個頁面
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    // sprintf %s挖洞插值
    $sql = sprintf("SELECT * FROM products ORDER BY sid DESC LIMIT %s,%s", ($page - 1) * $perPage, $perPage); //ASC為遞增排序 DESC為遞減
    //呈現一頁幾筆的寫法

    //ex.一頁五筆 索引值0,5,10,15   ex.頁數一的1到5筆,

    $rows = $pdo->query($sql)->fetchAll();
}


$output = [
    'totalRows' => $totalRows,
    'totalPages' => $totalPages,
    'page' => $page,
    'rows' => $rows,
    'perPage' => $perPage
];

//拿來測試用
// echo json_encode($output);
// exit;

?>

<?php include __DIR__ . '/parts/index_header.php' ?>


<?php include __DIR__ . '/parts/index_navber.php' ?>


<div class="container">

    <div class="row">
        <div class="col">
            <!-- 從https://getbootstrap.com/docs/5.2/components/pagination/
            去copy overview的再修改 -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <li class="page-item 
                    <?= 1 == $page ? 'disabled' : '' ?>">
                        <!-- disabled當前頁面數到底不重刷頁面 -->
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-arrow-left"></i>
                            <!-- https://fontawesome.com/icons/arrow-left?s=solid&f=classic -->
                        </a>
                    </li>

                    <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                            <li class="page-item 
                            <?= $i == $page ? 'active' : '' ?>">
                                <!-- active用在畫面停留當前頁數呈現反白 -->
                                <a class="page-link" href="?page=<?= $i ?>">
                                    <?= $i ?></a>
                            </li>
                    <?php
                        endif;
                    endfor; ?>

                    <li class="page-item 
                    <?= $totalPages == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <!-- 
            從https://getbootstrap.com/docs/5.2/content/tables/#overview
            的table的Striped rows去檢查Copy outerHTML再修改

            innerHTML只包含element
            outerHTML包含element及element的標籤-->
            <table class="table table-striped table-bordered">

                <thead>
                    <tr>

                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>

                        <th scope="col">ID</th>
                        <th scope="col">商品圖</th>
                        <th scope="col">商品名稱</th>
                        <th scope="col">售價</th>
                        <th scope="col">商品簡述</th>


                        <th scope="col">
                            <i class="fa-sharp fa-solid fa-pen-to-square"></i>
                        </th>

                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <!-- $rows as $r 是後面用 $r取代$row來表示 -->
                        <tr>

                            <td>
                                <a href="2_goods_delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm
                                ('確定要刪除編號<?= $r['sid'] ?>的資料嗎?')">

                                    <!-- 假連結刪除寫法
                                href等於 "javascript: delete_it
                                (<問號等於 $r['sid'] ?>)"
                                下方要加寫script fu-->

                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>

                            <!-- <問號等於 問號>為echo的縮寫用法 -->
                            <td><?= $r['sid'] ?></td>
                            <td><img src="./store/<?= $r['pic'] ?>" alt="" width="50" height="55"></td>
                            <td><?= $r['product_name'] ?></td>
                            <td><?= $r['price'] ?></td>
                            <td><?= $r['info'] ?></td>

                            <td>
                                <a href="2_goods_edit_form.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-sharp fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>




<?php include __DIR__ . '/parts/index_script.php' ?>



<script>
    const table = document.querySelector('table');

    // 假連結刪除寫法fuction

    // function delete_it(sid) {
    //     if (confirm(`確定要刪除編號為${sid}的資料嗎?`)) {
    //         location.href = `0914_delete.php?sid=${sid}`;
    //     }
    // }


    // table.addEventListener('click', function(event) {
    //     const t = event.target;
    //     console.log(event.target);
    //     if (t.classList.contains('fa-trash-can')) {
    //         t.closest('tr').remove();
    //     }
    //     if (t.classList.contains('fa-pen-to-square')) {
    //         console.log(
    //             t.closest('tr').querySelectorAll('td')[2].innerHTML
    //         );
    //     }
    // })
</script>


<?php include __DIR__ . '/parts/index_foot.php' ?>