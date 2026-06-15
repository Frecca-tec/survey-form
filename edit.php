<?php
require_once 'db.php';

$dbh = connectionDB();

$id = $_GET['id'] ?? null;

if (!$id) {
    exit('IDがありません');
}

// 更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $reservation_date = $_POST['reservation_date'] ?? '';
    $reservation_time = $_POST['reservation_time'] ?? '';
    $consultation_method = $_POST['consultation_method'] ?? '';
    $learning_languages = isset($_POST['learning_languages'])
        ? implode(',', $_POST['learning_languages'])
        : '';
    $os_env = $_POST['os_env'] ?? '';
    $consultation_categories = isset($_POST['consultation_categories'])
        ? implode(',', $_POST['consultation_categories'])
        : '';
    $details = $_POST['details'] ?? '';
    $urgency_level = $_POST['urgency_level'] ?? '';

    $sql = 'UPDATE reservations
            SET name = :name,
                email = :email,
                telephone = :telephone,
                reservation_date = :reservation_date,
                reservation_time = :reservation_time,
                consultation_method = :consultation_method,
                learning_languages = :learning_languages,
                os_env = :os_env,
                consultation_categories = :consultation_categories,
                details = :details,
                urgency_level = :urgency_level
            WHERE id = :id';

    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':telephone' => $telephone,
        ':reservation_date' => $reservation_date,
        ':reservation_time' => $reservation_time,
        ':consultation_method' => $consultation_method,
        ':learning_languages' => $learning_languages,
        ':os_env' => $os_env,
        ':consultation_categories' => $consultation_categories,
        ':details' => $details,
        ':urgency_level' => $urgency_level,
        ':id' => $id,
    ]);

    header('Location: list.php');
    exit;
}

// 既存データ取得
$sql = 'SELECT * FROM reservations WHERE id = :id';
$stmt = $dbh->prepare($sql);
$stmt->execute([':id' => $id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    exit('データが見つかりません');
}

$selected_languages = explode(',', $reservation['learning_languages'] ?? '');
$selected_categories = explode(',', $reservation['consultation_categories'] ?? '');

$methods = [
    'オンライン' => 'オンライン（Zoom）',
    '電話' => '電話',
    'メール' => 'メール',
    'チャット' => 'チャット',
    '対面' => '対面',
];

$languages = ['Python', 'JavaScript', 'PHP', 'Java', 'C#', 'Ruby', 'Go', 'C++', 'その他'];
$os_list = ['Windows', 'macOS', 'Linux'];
$categories = ['エラー解決', '設計相談', '学習方法', 'キャリア相談', 'コードレビュー', 'その他'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約編集</title>
</head>
<body>

<h1>予約編集</h1>

<form method="post">
    <div>
        <label>お名前 ※：</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($reservation['name'], ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div>
        <label>メールアドレス ※：</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($reservation['email'], ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div>
        <label>電話番号 任意：</label>
        <input type="text" name="telephone"
               value="<?= htmlspecialchars($reservation['telephone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div>
        <label>予約日 ※：</label>
        <input type="date" name="reservation_date"
               value="<?= htmlspecialchars($reservation['reservation_date'], ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div>
        <label>予約時間 ※：</label>
        <input type="time" name="reservation_time"
               value="<?= htmlspecialchars($reservation['reservation_time'], ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div>
      <label>相談方法 ※：</label>
      <?php foreach ($methods as $value => $label): ?>
        <label>
            <input type="radio" name="consultation_method"
                   value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>"
                   <?= $reservation['consultation_method'] === $value ? 'checked' : '' ?>>
            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
        </label>
      <?php endforeach; ?>
    </div>
    <div>
        <label>学習言語 ※：</label>
        <?php foreach ($languages as $language): ?>
            <label>
                <input type="checkbox" name="learning_languages[]"
                       value="<?= htmlspecialchars($language, ENT_QUOTES, 'UTF-8') ?>"
                       <?= in_array($language, $selected_languages, true) ? 'checked' : '' ?>>
                <?= htmlspecialchars($language, ENT_QUOTES, 'UTF-8') ?>
            </label>
        <?php endforeach; ?>
    </div>

    <div>
        <label>OS環境：</label>
        <?php foreach ($os_list as $os): ?>
            <label>
                <input type="radio" name="os_env"
                       value="<?= htmlspecialchars($os, ENT_QUOTES, 'UTF-8') ?>"
                       <?= $reservation['os_env'] === $os ? 'checked' : '' ?>>
                <?= htmlspecialchars($os, ENT_QUOTES, 'UTF-8') ?>
            </label>
        <?php endforeach; ?>
    </div>

    <div>
        <label>相談カテゴリ ※：</label>
        <?php foreach ($categories as $category): ?>
            <label>
                <input type="checkbox" name="consultation_categories[]"
                       value="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>"
                       <?= in_array($category, $selected_categories, true) ? 'checked' : '' ?>>
                <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>
            </label>
        <?php endforeach; ?>
    </div>

    <div>
        <label>相談内容の詳細 ※：</label><br>
        <textarea name="details" rows="6" cols="40"><?= htmlspecialchars($reservation['details'], ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>

    <div>
      <label>緊急度（対応の優先度）：</label>
      <input type="range"
           id="urgency_level"
           name="urgency_level"
           min="1"
           max="5"
           value="<?= htmlspecialchars($reservation['urgency_level'], ENT_QUOTES, 'UTF-8') ?>">

      <span id="urgencyValue">
        <?= htmlspecialchars($reservation['urgency_level'], ENT_QUOTES, 'UTF-8') ?>
      </span>
    </div>
    <br><br>
    <button type="submit">更新する</button>
</form>

<p><a href="list.php">一覧へ戻る</a></p>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $('#urgency_level').on('input', function() {
    $('#urgencyValue').text(this.value);
  });
</script>
</html>