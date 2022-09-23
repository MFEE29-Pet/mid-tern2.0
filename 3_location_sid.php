<?php
require __DIR__ . '/parts/__connect_db.php';

// $pageName = 'list'; // 頁面名稱
// $title = '資料列表';

// $perPage = 20;  // 每頁最多有幾筆
// $page = isset($_GET['page']) ? intval($_GET['page']) : 1;



// // 取得資料的總筆數
// $t_sql = "SELECT COUNT(1) FROM address_book";
// $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// // 計算總頁數
// $totalPages = ceil($totalRows / $perPage);

// $rows = [];  // 預設值
// // 有資料才執行
// if ($totalRows > 0) {
//     if ($page < 1) {
//         header('Location: ?page=1');
//         exit;
//     }
//     if ($page > $totalPages) {
//         header('Location: ?page=' . $totalPages);
//         exit;
//     }
    // 取得該頁面的資料
    
// }
    $sql = sprintf(
        "SELECT * FROM `location_sid`
            JOIN `background_management`
            ON `roomtype_id` = background_management.sid
            ORDER BY `evaluation_camping`.sid DESC"
    );
    $rows = $pdo->query($sql)->fetchAll();

/*
echo json_encode([
    'totalRows' => $totalRows,
    'totalPages' => $totalPages,
    'perPage' => $perPage,
    'page' => $page,
    'rows' => $rows,
]);
exit;
*/


?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="container">
    
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                        <th scope="col">編號</th>
                        <th scope="col">露營地點</th>
                        <th scope="col">地址</th>

                        <th scope="col">手機</th>
                        <th scope="col">星空區</th>
                        <th scope="col">萌萌包</th>
                        <th scope="col">獵人之家</th>
                        
                        <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="javascript: remove_it(<?= $r['sid'] ?>)"
                                    data-onclick="event.currentTarget.closest('tr').remove()"
                                >
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['location_sid'] ?></td>
                            <td><?= $r['address'] ?></td>
                            <td><?= $r['phone'] ?></td>
                            <td><?= $r['starry_sky'] ?></td>
                            <td><?= $r['mongolian_yurt'] ?></td>
                            <td><?= $r['hunters_home'] ?></td>
                            <td>
                                <!-- 修改訂單編號 -->
                                <a href="3_order-edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>

            </table>
        </div>
    </div>


</div>
<?php include __DIR__ . '/parts/index_script.php'; ?>
<script>
    function remove_it(sid){
        if(confirm(`是否要刪除編號為 ${sid} 的資料?`)){
            location.href = `3_camping_order.php?sid=${sid}`;
        }
    }

</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>