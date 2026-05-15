<?php
require_once 'function.php';

// POSTデータ取得
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$reservation_date = $_POST['reservation_date'] ?? '';
$reservation_time = $_POST['reservation_time'] ?? '';
$consultation_method = $_POST['consultation_method'] ?? '';
$learning_languages_array = $_POST['learning_languages'] ?? [];
$os_env = $_POST['os_env'] ?? '';
$consultation_categories_array = $_POST['consultation_categories'] ?? [];
$details = $_POST['details'] ?? '';
$urgency_level = $_POST['urgency_level'] ?? '3';

// 表示用に整形
$learning_languages = !empty($learning_languages_array) ? implode('、', $learning_languages_array) : '未選択';
$consultation_categories = !empty($consultation_categories_array) ? implode('、', $consultation_categories_array) : '未選択';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メンター予約フォーム（確認）</title>
</head>
<body>

<h1>メンター予約フォーム（確認）</h1>
<p>以下の内容で登録してよろしいですか？</p>

<p>お名前：<?= h($name) ?></p>
<p>メール：<?= h($email) ?></p>
<p>電話番号：<?= h($telephone) ?></p>
<p>予約日：<?= h($reservation_date) ?></p>
<p>予約時間：<?= h($reservation_time) ?></p>
<p>相談方法：<?= h($consultation_method) ?></p>
<p>学習言語：<?= h($learning_languages) ?></p>
<p>OS環境：<?= h($os_env) ?></p>
<p>相談カテゴリー：<?= h($consultation_categories) ?></p>
<p>相談内容の詳細：<?= h($details) ?></p>
<p>緊急度：<?= h($urgency_level) ?></p>

<form action="index.php" method="post">
  <input type="hidden" name="name" value="<?= h($name) ?>">
  <input type="hidden" name="email" value="<?= h($email) ?>">
  <input type="hidden" name="telephone" value="<?= h($telephone) ?>">
  <input type="hidden" name="reservation_date" value="<?= h($reservation_date) ?>">
  <input type="hidden" name="reservation_time" value="<?= h($reservation_time) ?>">
  <input type="hidden" name="consultation_method" value="<?= h($consultation_method) ?>">

  <?php foreach ($learning_languages_array as $lang): ?>
    <input type="hidden" name="learning_languages[]" value="<?= h($lang) ?>">
  <?php endforeach; ?>

  <input type="hidden" name="os_env" value="<?= h($os_env) ?>">

  <?php foreach ($consultation_categories_array as $category): ?>
    <input type="hidden" name="consultation_categories[]" value="<?= h($category) ?>">
  <?php endforeach; ?>

  <input type="hidden" name="details" value="<?= h($details) ?>">
  <input type="hidden" name="urgency_level" value="<?= h($urgency_level) ?>">

  <button type="submit">戻る</button>
  <button type="submit" formaction="complete.php">登録</button>
</form>

</body>
</html>