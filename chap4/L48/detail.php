<?php
$user = '●●●';
$pass = '●●●';
if (empty($_GET['id'])) {
    echo 'IDを正しく入力してください。';
    exit;
}
try {
    $id = (int)$_GET['id'];
    $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM recipes WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '料理名:' . htmlspecialchars($result['recipe_name'], ENT_QUOTES) . '<br>' . PHP_EOL;
    echo 'カテゴリ:' .
    match ($result['category']) {
        '1' => '和食',
        '2' => '中華',
        '3' => '洋食',
    } . '<br>' . PHP_EOL;
    echo '予算:' . htmlspecialchars($result['budget'],ENT_QUOTES) . '<br>' . PHP_EOL;
    echo '難易度:' .
    match ($result['difficulty']) {
        '1' => '簡単',
        '2' => '普通',
        '3' => '難しい',
    } . '<br>' . PHP_EOL;
    echo '作り方:<br>' . nl2br(htmlspecialchars($result['howto'], ENT_QUOTES)) . '<br>' . PHP_EOL;
    $dbh = null;
    echo'<a href="index.php">トップページへ戻る</a>';
} catch (PDOException $e) {
    echo 'エラー発生: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>';
    exit;
}
?>