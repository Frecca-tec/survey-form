<?php
require_once 'function.php';
require_once 'db.php';

// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

// データベースに接続
$dbh = connectionDB();

// POSTデータ取得
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$reservation_date = $_POST['reservation_date'] ?? '';
$reservation_time = $_POST['reservation_time'] ?? '';
$consultation_method = $_POST['consultation_method'] ?? '';
$learning_languages = $_POST['learning_languages'] ?? [];
$os_env = $_POST['os_env'] ?? '';
$consultation_categories = $_POST['consultation_categories'] ?? [];
$details = $_POST['details'] ?? '';
$urgency_level = $_POST['urgency_level'] ?? '3';
// 登録日時
$created_at = date('Y-m-d H:i:s');

try {
  //SQLの型（入れ物）を作る
  $sql = 'INSERT INTO reservations (name, email, telephone, reservation_date, reservation_time, consultation_method, learning_languages, os_env, consultation_categories, details, urgency_level, created_at) VALUES (:name, :email, :telephone, :reservation_date, :reservation_time, :consultation_method, :learning_languages, :os_env, :consultation_categories, :details, :urgency_level, :created_at)';

  // PDOが安全なSQLとして準備
  $stmt = $dbh->prepare($sql);

  // 実際の値を流し込む
  $stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':telephone' => $telephone,
    ':reservation_date' => $reservation_date,
    ':reservation_time' => $reservation_time,
    ':consultation_method' => $consultation_method,
    ':learning_languages' => implode(',', $learning_languages),
    ':os_env' => $os_env,
    ':consultation_categories' => implode(',', $consultation_categories),
    ':details' => $details,
    ':urgency_level' => $urgency_level,
    ':created_at' => $created_at
  ]);
  echo '予約を登録しました！</p>';
  echo '<a href="index.php">入力画面へ戻る</a></p>';
  echo '<a href="list.php">登録一覧表に進む</a></p>';
}
catch (PDOException $e) {
  echo '登録エラー：' . $e->getMessage();
  echo '<a href="index.php">入力画面へ戻る</a>';
  exit();
}
