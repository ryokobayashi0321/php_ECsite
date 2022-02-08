<?php

session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) === false) {
    echo 'ログインしていません。' . PHP_EOL;
    echo '<a href="staff_login.html">ログイン画面へ</a>';
    exit();
} else {
    echo $_SESSION['name'] . 'さんログイン中' . PHP_EOL;
    echo '<br><br>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧リスト</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php

try {
    require_once('../common/common.php');
    $dbh = dbConnect();
    $sql = 'SELECT code, name, price FROM mst_product WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    echo '商品一覧<br><br>';
    echo '<form action="pro_branch.php" method="post">';

    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec === false) {
            break;
        }
        echo '<input type="radio" name="code" value="'.$rec['code'].'">';
        echo $rec['name'];
        echo '---';
        echo $rec['price'] . '円';
        echo '<br>';
    }
    echo '<br>';
    echo '<input type="submit" name="show" value="詳細">';
    echo '<input type="submit" name="add" value="追加">';
    echo '<input type="submit" name="edit" value="修正">';
    echo '<input type="submit" name="delete" value="削除">';
} catch (Exception $e) {
    echo '只今障害が発生しております。' . PHP_EOL;
    echo '<a href ="../staff_login/staff_login.html">ログイン画面へ</a>';
}
?>
    <br><br>
    <a href="../staff_login/staff_login_top.php">管理者画面TOPへ</a>
</body>
</html>