<?php
// Your PHP code here
require_once 'function.php';
require_once 'db.php';

// データベースに接続
$dbh = connectionDB();

// 並び替え条件を取得
$sort = $_GET['sort'] ?? 'id_asc';

// 並び替え条件を変更
$orderBy = match ($sort) {
    'id_asc' => 'id ASC',
    'id_desc' => 'id DESC',
    'created_at_asc' => 'created_at ASC',
    'created_at_desc' => 'created_at DESC',
    'reservation_date_asc' => 'reservation_date ASC, reservation_time ASC',
    'reservation_date_desc' => 'reservation_date DESC, reservation_time DESC',
    'urgency_level_desc' => 'urgency_level DESC',
    'urgency_level_asc' => 'urgency_level ASC',
    default => 'id ASC',
};

// 検索キーワードを取得
$keyword = $_GET['keyword'] ?? '';
$where = '';
$params = [];

if ($keyword !== '') {
    $where = 'WHERE name LIKE :keyword';
    //あいまい検索用 % : 前後にワイルドカードを追加して、部分一致検索を可能にする
    $params[':keyword'] = '%' . $keyword . '%';
}

// 予約データを取得
try {
  // $sql = 'SELECT * FROM reservations';
  // $orderBy(並び替え）をSQL文に組み込む
  $sql = "SELECT * FROM reservations {$where} ORDER BY {$orderBy}";

  // PDOが安全なSQLとして準備
  $stmt = $dbh->prepare($sql);

  //$params 検索条件の荷物箱
  foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
  }

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
    <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body>
  <!-- d-flex : 横並びの要素を配置 -->
  <!-- fluid px-3 : コンテナの左右のパディングを設定 -->
  <div class="container-fluid px-3">

  <div class="d-flex align-items-center gap-3 mb-3">
    <h1 class="m-0">予約一覧</h1>
    <a href="index.php" class="btn btn-primary">
        入力画面へ戻る
      </a>
  </div>

  <div class="mb-3">
  <a href="list.php?sort=id_asc" class="btn btn-outline-dark btn-sm">ID 昇順</a>
  <a href="list.php?sort=id_desc" class="btn btn-outline-dark btn-sm">ID 降順</a>
  <a href="list.php?sort=created_at_desc" class="btn btn-outline-secondary btn-sm">新しい順</a>
  <a href="list.php?sort=created_at_asc" class="btn btn-outline-secondary btn-sm">古い順</a>
  <a href="list.php?sort=name_asc" class="btn btn-outline-success  btn-sm">名前 昇順</a>
  <a href="list.php?sort=name_desc" class="btn btn-outline-success btn-sm">名前 降順</a>
  <a href="list.php?sort=reservation_date_asc" class="btn btn-outline-primary btn-sm">予約日順</a>
  <a href="list.php?sort=reservation_date_desc" class="btn btn-outline-primary btn-sm">予約日順（降順）</a>
  <a href="list.php?sort=urgency_level_desc" class="btn btn-outline-danger btn-sm">緊急度（降順）</a>
  <a href="list.php?sort=urgency_level_asc" class="btn btn-outline-danger btn-sm">緊急度（昇順）</a>
  
  <!-- 検索フォーム -->
  <form method="get" action="list.php" class="mb-3 d-flex align-items-center gap-2">
  <input
    type="text"
    name="keyword"
    class="form-control w-auto"
    placeholder="名前で検索"
    value="<?= h($keyword) ?>"
  >
  <input type="hidden" name="sort" value="<?= h($sort) ?>">
  <button type="submit" class="btn btn-primary btn-sm">検索</button>
  <a href="list.php" class="btn btn-secondary btn-sm">リセット</a>
  </form>
  
  </div>

    <!-- 予約データがない場合のメッセージ -->
    <?php if (count($reservations) === 0): ?>
    <p>予約データはまだありません。</p>
    <?php else: ?>
    <!-- table-hover : ホバー時に行の背景色が変化する -->
    <table class="table table-hover">
      <thead class="table-dark text-center">
        <tr>
          <!-- テーブルのヘッダー -->
            <th>ID</th>
            <th>お名前</th>
            <th>予約日</th>
            <th>予約時間</th>
            <th>相談方法</th>
            <th>緊急度</th>
            <th>登録日時</th>
            <th colspan="3">操作</th>
        </tr>
      </thead>
        <!-- データを表示 -->
        <?php foreach ($reservations as $reservation): ?>
        <tr>
            <td><?= h($reservation['id']) ?></td>
            <td><?= h($reservation['name']) ?></td>
            <td><?= h($reservation['reservation_date']) ?></td>
            <td><?= h($reservation['reservation_time']) ?></td>
            <td><?= h($reservation['consultation_method']) ?></td>
            <td><?= h($reservation['urgency_level']) ?></td>
            <td><?= h($reservation['created_at']) ?></td>
            <td>
              <!-- 詳細リンク -->
              <a href="detail.php?id=<?= h($reservation['id']) ?>" class="btn btn-info btn-sm">詳細</a>
              <!-- 編集リンク -->
              <!-- btn-sm : ボタンを小さく表示 -->
                <a href="edit.php?id=<?= h($reservation['id']) ?>" class="btn btn-success btn-sm">編集</a>
              <!-- 削除リンク -->
              <a href="delete.php?id=<?= h($reservation['id']) ?>" class="btn btn-danger btn-sm" 
              onclick="return confirm('本当に削除しますか？')">削除</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
  </div>
  </body>
</html>