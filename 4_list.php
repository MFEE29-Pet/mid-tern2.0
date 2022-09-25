<?php require __DIR__ . '/parts/connect_db.php';
$pageName = 'list';

$perPage = 20; // 一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// 算總筆數
$t_sql = "SELECT COUNT(1) FROM address_book ";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);

$rows = [];
// 如果有資料
if ($totalRows) {
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf(
        "SELECT * FROM address_book ORDER BY sid DESC LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}

$output = [
    'totalRows' => $totalRows,
    'totalPages' => $totalPages,
    'page' => $page,
    'rows' => $rows,
    'perPage' => $perPage,
];

// echo json_encode($output); exit;

?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
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

                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
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

    <?php 
    if(empty($_SESSION['admin'])){
        include __DIR__. '/list-table-no-admin.php';
    } else {
        include __DIR__. '/list-table-admin.php';
    }
    
    ?>


</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
const table = document.querySelector('table');

function delete_it(sid) {
    if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
        location.href = `delete.php?sid=${sid}`;
    }
}
/*
table.addEventListener('click', function(event){
    const t = event.target;
    console.log(event.target);
    if(t.classList.contains('fa-trash-can')){
        t.closest('tr').remove();
    }
    if(t.classList.contains('fa-pen-to-square')){
        // console.log(t.closest('tr').querySelectorAll('td'));
        
        console.log( 
            t.closest('tr').querySelectorAll('td')[2].innerHTML
        );
        
    }
});
*/
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>