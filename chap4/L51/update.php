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
$id = (int) $_GET['id'];
if (($id < 1) || ($id) > 1000 ) {
    echo 'IDが範囲外です。';
    exit;
}
$error = require 'error_chk.php';
if (!empty($error)) {
    foreach($error as $value) {
        echo $value . '<br>' . PHP_EOL;
    }
    exit;
}
$recipe_name = $_POST['recipe_name'];
$how to = $_POST['how to'];
$category = (int) $_POST['category'];
$difficulty = (int) $_POST['difficulty'];
$budget = (int) $_POST['budget'];
try {
    $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERR MODE, PDO::ERR MODE_EXCEPTION);
    $sql = 'UPDATE recipes SET recipe_name = ?, category = ?, difficulty = ?, budget = ?, how to = ? WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $recipe_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $category, PDO::PARAM_INT);
    $stmt->bindValue(3, $difficulty, PDO::PARAM_INT);
    $stmt->bindValue(4, $budget, PDO::PARAM_INT);
    $stmt->bindValue(5, $how to, PDO::PARAM_STR);
    $stmt->bindValue(6, $id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;
    echo 'ID: ' . htmlspecialchars($id,ENT_QUOTES,'UTF-8') . 'レシピの更新が完了しました。<br>';
    echo '<a href="index.php">トップページへ戻る</a>';
} catch (PDOException $e) {
    echo 'エラー発生: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '<br>';
    exit;
}
?>