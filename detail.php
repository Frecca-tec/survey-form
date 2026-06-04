<?php
// Your PHP code here
require_once 'function.php';
require_once 'db.php';

// データベースに接続
$dbh = connectionDB();

// 予約IDを取得
$reservationId = $_GET['id'] ?? null;

if ($reservationId) {
    try {
        // 予約データを取得
        $sql = 'SELECT * FROM reservations WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $reservationId, PDO::PARAM_INT);
        $stmt->execute();
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            echo '予約が見つかりませんでした。';
            exit;
        }
    } catch (PDOException $e) {
        echo 'データ取得エラー：' . $e->getMessage();
        exit;
    }
} else {
    echo '予約IDが指定されていません。';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約詳細</title>
</head>
<body>
    <h1>予約詳細</h1>
    <p>予約ID: <?php echo htmlspecialchars($reservation['id']); ?></p>
    <p>お名前: <?php echo htmlspecialchars($reservation['name']); ?></p>
    <p>メールアドレス: <?php echo htmlspecialchars($reservation['email']); ?></p>
    <p>電話番号: <?php echo htmlspecialchars($reservation['telephone']); ?></p>
    <p>予約日: <?php echo htmlspecialchars($reservation['reservation_date']); ?></p>
    <p>予約時間: <?php echo htmlspecialchars($reservation['reservation_time']); ?></p>
    <p>相談方法: <?php echo htmlspecialchars($reservation['consultation_method']); ?></p>
    <p>学習言語: <?php echo htmlspecialchars($reservation['learning_languages']); ?></p>
    <p>OS環境: <?php echo htmlspecialchars($reservation['os_env']); ?></p>
    <p>相談カテゴリー: <?php echo htmlspecialchars($reservation['consultation_categories']); ?></p>
    <p>相談内容の詳細: <?php echo nl2br(htmlspecialchars($reservation['details'])); ?></p>
    <p>緊急度: <?php echo htmlspecialchars($reservation['urgency_level']); ?></p>
    <p>作成日時: <?php echo htmlspecialchars($reservation['created_at']); ?></p>
    <a href="list.php">予約一覧に戻る</a>
</body>
</html>