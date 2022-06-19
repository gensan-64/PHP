<?php
$error = [];
if (empty($_POST['recipe_name'])) {
    $error['recipe_name'] = '料理名は必須です。';
} elseif (mb_strlen($_POST['recipe_name']) > 45) {
    $error['recipe_name'] = '料理名を正しく入力してください。';
}
if (!preg_match('/\A[123]\z/', $_POST['category'])) {
    $error['category'] = 'カテゴリを正しく入力してください。';
}
if (!preg_match('/\A[123]\z/', $_POST['difficulty'])) {
    $error['difficulty'] = '難易度を正しく入力してください。';
}
$options = ['options' => ['min_range' => 0, 'max_range' => 9999]];
if (filter_var($_POST['budget'], FILTER_VALIDATE_INT, $options) === false) {
    $error['budget'] = '予算を正しく入力してください。';
}
if (mb_strlen($_POST['howto']) > 320) {
    $error['howto'] = '作り方を正しく入力してください。';
}
return $error;