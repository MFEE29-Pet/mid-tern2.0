
<?php require __DIR__ . '/parts/goods_connect_db.php';

// php內正確註解方式用 /* */前後包 

$perPage = 3;
//設定一頁最多有5筆資料

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//用戶沒選頁數時 把第1頁設成預設顯示的寫法

// http://localhost/php_test/address_book/0913_list.php
// 網址尾巴加上 ?page=2 為前往第幾頁

//算總筆數 不需要欄位名 只需要筆數 所以用PDO::FETCH_NUM
$t_sql = "SELECT COUNT(1) FROM products";
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


header('Content-Type: application/json');
echo json_encode($output);
