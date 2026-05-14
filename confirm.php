<?php
require_once 'function.php';

// echo '<pre>';
// フォームから送信されたデータを表示
// var_dump は、変数の内容をわかりやすく表示する関数
// var_dump($_POST);

echo '<p>お名前：' . h($_POST['name'] ?? '') . '</p>';
echo '<p>メール：' . h($_POST['email'] ?? '') . '</p>';
echo '<p>電話番号：' . h($_POST['telephone'] ?? '') . '</p>';
echo '<p>予約日：' . h($_POST['reservation_date'] ?? '') . '</p>';
echo '<p>予約時間：' . h($_POST['reservation_time'] ?? '') . '</p>';
echo '<p>相談方法：' . h($_POST['consultation_method'] ?? '') . '</p>';

// 複数選択された学習言語を「、」で結合して表示
// isset : 変数がセットされているかどうかを確認する関数
// implode : 配列の要素を文字列に結合する関数
// 学習言語が選択されていない場合は「未選択」と表示
// 「? : 」 : 三項演算子と呼ばれる条件演算子で、条件式 ? 真の場合の値 : 偽の場合の値 の形式で使用される
$learning_languages = isset($_POST['learning_languages']) ? implode('、', $_POST['learning_languages']) : '未選択';
echo '<p>学習言語：' . h($learning_languages) . '</p>';

echo '<p>OS環境：' . h($_POST['os_env'] ?? '') . '</p>';

$consultation_categories = isset($_POST['consultation_categories']) ? implode('、', $_POST['consultation_categories']) : '未選択';
echo '<p>相談カテゴリー：' . h($consultation_categories) . '</p>';

echo '<p>相談内容の詳細：' . h($_POST['details'] ?? '') . '</p>';
echo '<p>緊急度：' . h($_POST['urgency_level'] ?? '') . '</p>';

// echo '</pre>';
?>

<!-- フォームに戻るためのリンク -->
<form action="index.php" method="post">
  <!-- hidden : 非表示状態でデータを送信する -->
  <input type="hidden" name="name" value="<?= h($_POST['name'] ?? '') ?>">
  <input type="hidden" name="email" value="<?= h($_POST['email'] ?? '') ?>">
  <input type="hidden" name="telephone" value="<?= h($_POST['telephone'] ?? '') ?>">
  <input type="hidden" name="reservation_date" value="<?= h($_POST['reservation_date'] ?? '') ?>">
  <input type="hidden" name="reservation_time" value="<?= h($_POST['reservation_time'] ?? '') ?>">
  <input type="hidden" name="consultation_method" value="<?= h($_POST['consultation_method'] ?? '') ?>">
 
  <!-- 学習言語は複数選択される可能性があるため、ループでhiddenフィールドを生成 -->
  <!-- 配列 as 変数 配列の中身を変数に格納  -->
  <?php foreach ($_POST['learning_languages'] ?? [] as $lang): ?>
  <input type="hidden" name="learning_languages[]" value="<?= h($lang) ?>">
  <?php endforeach; ?>

  <input type="hidden" name="os_env" value="<?= h($_POST['os_env'] ?? '') ?>">

  <!-- 相談カテゴリーは複数選択される可能性があるため、ループでhiddenフィールドを生成 -->
  <?php foreach ($_POST['consultation_categories'] ?? [] as $category): ?>
  <input type="hidden" name="consultation_categories[]" value="<?= h($category) ?>">
  <?php endforeach; ?>

  <input type="hidden" name="details" value="<?= h($_POST['details'] ?? '') ?>">
  <input type="hidden" name="urgency_level" value="<?= h($_POST['urgency_level'] ?? '') ?>">
  <button type="submit">戻る</button>

  <!-- formaction : ボタンがクリックされたときに送信されるURLを指定 -->
  <button type="submit" formaction="complete.php">登録</button>
</form>
