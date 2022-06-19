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
    $sql = 'DELETE FROM recipes WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;
    echo 'ID: ' . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . 'の削除が完了しました。<br>';
    echo'<a href="index.php">トップページへ戻る</a>';
} catch (PDOException $e) {
    echo 'エラー発生: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '<br>';
    exit;
}
?>