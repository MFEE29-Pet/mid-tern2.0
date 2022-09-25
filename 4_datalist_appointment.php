<?php
require __DIR__ . '/parts/connect_db.php';

// $pageName = 'list'; // 頁面名稱
// $title = '資料列表';

$perPage = 5;  // 每頁最多有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;



// 取得資料的總筆數
$t_sql = "SELECT COUNT(1) FROM appointment";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// 計算總頁數
$totalPages = ceil($totalRows / $perPage);

$rows = [];  // 預設值
// 有資料才執行
if ($totalRows > 0) {
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }
    // 取得該頁面的資料
    
}
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;


// $sql ="SELECT a.*, c.`clinic_name` ,s.`symptom_name`
//     FROM `appointment` a
//     JOIN `clinic` c
//     ON a.`clinic_sid`= c.`sid`
//     JOIN `symptom` s
//     ON a.`symptom_sid`=s.`sid`;
//     ";

$sql = sprintf("SELECT a.*, c.`clinic_name` ,s.`symptom_name`
    FROM `appointment` a
    JOIN `clinic` c
    ON a.`clinic_sid`= c.`sid`
    JOIN `symptom` s
    ON a.`symptom_sid`=s.`sid` ORDER BY `sid` DESC LIMIT %s,%s", ($page -1)*$perPage, $perPage);

$rows = $pdo->query($sql)->fetchAll();



// echo json_encode([
//     'totalRows' => $totalRows,
//     'totalPages' => $totalPages,
//     'perPage' => $perPage,
//     'page' => $page,
//     'rows' => $rows,
// ]);
// exit;


?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<?php include __DIR__ . '/parts/index_navber.php'; ?>


<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                        </a>
                    </li>

                    <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php
                        endif;
                    endfor; ?>

                    <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-circle-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <div class="container">

        <div class="row">
            <div class="col">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                            <th scope="col">編號</th>
                            <th scope="col">掛號日期</th>
                            <!-- <th scope="col">星期</th> -->
                            <th scope="col">診所名稱</th>
                            <th scope="col">預約時段</th>
                            <th scope="col">不適症狀</th>
                            <th scope="col">看診序號</th>
                            <th scope="col">預約時間</th>
                            <th scope="col">會員編號</th>
                            <th scope="col">寵物晶片</th>

                            <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r) : ?>
                        <?php //foreach ($s_rows as $s_r) : ?>
                        <tr>
                            <td>
                                <a href="javascript: removeItem(<?= $r['sid'] ?>)"
                                    data-onclick="event.currentTarget.closest('tr').remove()">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['date'] ?></td>
                            <td><?= $r['clinic_name'] ?></td>
                            <td><?= $r['service_hours'] ?></td>
                            <td><?= $r['symptom_name'] ?></td>
                            <td><?= $r['serial_number'] ?></td>
                            <td><?= $r['create_at'] ?></td>
                            <td><?= $r['member_sid'] ?></td>
                            <td><?= $r['pet_sid'] ?></td>
                            <td>
                                <a href="4_edit_form_appointment.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php //endforeach;?>

                    </tbody>

                </table>
            </div>
        </div>


    </div>
    <?php include __DIR__ . '/parts/index_script.php'; ?>
    <script>
    function removeItem(sid) {
        if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
            location.href = `4_delete_appointment.php?sid=${sid}`;
        }
    }
    </script>
    <?php include __DIR__ . '/parts/index_footer.php'; ?>