<?php
$user = '●●●';
$pass = '●●●';
if (empty($_GET['id'])) {
    echo 'IDを正しく入力してください。';
    exit;
}
try {
    $id = (int)$_GET['id'];
    var_dump($id);
} catch (PDOException $e) {
    echo 'エラー発生: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>';
    exit;
}