<?php
// Your PHP code here
require_once 'function.php';
require_once 'db.php';

// データベースに接続
$dbh = connectionDB();

// 予約データを取得
try {
  $sql = 'SELECT * FROM reservations';

  // PDOが安全なSQLとして準備
  $stmt = $dbh->prepare($sql);

  // SQLを実行
  $stmt->execute();

  // データ取得
  //FeTCH_ASSOCは、取得したデータを連想配列で返す
  $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo 'データ取得エラー：' . $e->getMessage();
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約一覧</title>
</head>
<body>
    <h1>予約一覧</h1>
    <?php if (count($reservations) === 0): ?>
    <p>予約データはまだありません。</p>
    <?php else: ?>
    <table border="1">
        <tr>
          <!-- テーブルのヘッダー -->
            <th>ID</th>
            <th>お名前</th>
            <th>メール</th>
            <th>電話番号</th>
            <th>予約日</th>
            <th>予約時間</th>
            <th>相談方法</th>
            <th>学習言語</th>
            <th>OS環境</th>
            <th>相談カテゴリー</th>
            <th>相談内容の詳細</th>
            <th>緊急度</th>
            <th>登録日時</th>
        </tr>
        <!-- データを表示 -->
        <?php foreach ($reservations as $reservation): ?>
        <tr>
            <td><?= h($reservation['id']) ?></td>
            <td><?= h($reservation['name']) ?></td>
            <td><?= h($reservation['email']) ?></td>
            <td><?= h($reservation['telephone']) ?></td>
            <td><?= h($reservation['reservation_date']) ?></td>
            <td><?= h($reservation['reservation_time']) ?></td>
            <td><?= h($reservation['consultation_method']) ?></td>
            <td><?= h($reservation['learning_languages']) ?></td>
            <td><?= h($reservation['os_env']) ?></td>
            <td><?= h($reservation['consultation_categories']) ?></td>
            <td><?= h($reservation['details']) ?></td>
            <td><?= h($reservation['urgency_level']) ?></td>
            <td><?= h($reservation['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <p><a href="index.php">入力画面へ戻る</a></p>
</body>
</html>