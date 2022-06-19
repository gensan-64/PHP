<?php
require_once __DIR__ . '/../../db_config.php';
if (!isset($_GET['id'])) {
    echo 'IDが入力されていません。';
    exit;
}
if (!preg_match('/\A[0-9]{1,4}\z/', $_GET['id'])) {
    echo 'IDを正しく入力してください';
    exit;
}
$id = (int)$_GET['id'];
if (($id < 1) || ($id) > 1000 ) {
    echo 'IDが範囲外です。';
    exit;
}
try {
    $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM recipes WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '料理名:' . htmlspecialchars($result['recipe_name'], ENT_QUOTES, 'UTF-8') . '<br>' . PHP_EOL;
    echo 'カテゴリ:' . htmlspecialchars($result['category'], ENT_QUOTES, 'UTF-8') . '<br>' . PHP_EOL;
    echo '予算:' . htmlspecialchars($result['budget'], ENT_QUOTES, 'UTF-8') . '<br>' . PHP_EOL;
    echo '難易度:' . htmlspecialchars($result['difficulty'], ENT_QUOTES, 'UTF-8') . '<br>' . PHP_EOL;
    echo '作り方:<br>' . nl2br(htmlspecialchars($result['howto'], ENT_QUOTES, 'UTF-8')) . '<br>' . PHP_EOL;
    $dbh = null;
    echo '<a href="index.php">トップページへ戻る</a>';
} catch (PDOException $e) {
    echo 'エラー発生: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '<br>';
    exit;
}
