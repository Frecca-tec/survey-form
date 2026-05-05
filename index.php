<?php
  //確認画面から入力画面に戻る際に、入力内容を保持するための処理
  require_once 'function.php';

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
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メンター予約フォーム（入力）</title>
</head>

<style>
.range-area {
  width: 300px;
  margin: 10px;
}

/* ラベルを均等に配置するためのスタイル */
.range-area input[type="range"] {
  width: 100%;
  margin: 0;
  display: block;
}

/* 目盛りラベルのスタイル */
.range-labels {
  display: flex;
  justify-content: space-between;
  width: 100%;   
  margin-top: 8px;
}

/* スライダー下の目盛り（1〜5）を均等に配置し、中央揃えにする */
.range-labels span {
  width: 20px;
  text-align: center;
  font-size: 12px;
  line-height: 1.2;
}
</style>

<body>
  <h1>メンター予約フォーム（入力）</h1>
  <p>以下のフォームに必要事項を入力してください。</p>
  <p>※必須項目はすべて入力してください。</p>
  <!-- エラーメッセージを表示するための要素 -->
  <div id="errorMessages" style="color:red;"></div>

  <!-- onsubmit : フォーム送信の直前に実行される処理（バリデーションチェック）-->
  <form method="post" action="confirm.php" onsubmit="return validateForm()">
    <label for="name">お名前 ※ : </label>
    <input type="text" id="name" name="name" value="<?= h($name) ?>" placeholder="例：山田太郎">
    <br>
    <label for="email">メールアドレス ※ : </label>
    <input type="email" id="email" name="email" value="<?= h($email) ?>">
    <br>
    <label for="telephone">電話番号(任意) : </label>
    <input type="tel" id="telephone" name="telephone" value="<?= h($telephone) ?>">
    <br>
    <label for="reservation_date">予約日 ※ : </label>
    <input type="date" id="reservation_date" name="reservation_date" value="<?= h($reservation_date) ?>">
    <br>
    <label for="reservation_time">予約時間 ※ : </label>
    <input type="time" id="reservation_time" name="reservation_time" value="<?= h($reservation_time) ?>">
    <br>

    <label for="consultation_method">相談方法 ※ : </label>
    <input type="radio" id="online" name="consultation_method" value="オンライン"  <?= $consultation_method === 'オンライン' ? 'checked' : '' ?>>
    <label for="online">オンライン（Zoom）</label>
    <input type="radio" id="phone" name="consultation_method" value="電話" <?= $consultation_method === '電話' ? 'checked' : '' ?>>
    <label for="phone">電話</label>
    <input type="radio" id="email_method" name="consultation_method" value="メール" <?= $consultation_method === 'メール' ? 'checked' : '' ?>>
    <label for="email_method">メール</label>
    <input type="radio" id="chat" name="consultation_method" value="チャット" <?= $consultation_method === 'チャット' ? 'checked' : '' ?>>
    <label for="chat">チャット</label>
    <input type="radio" id="in_person" name="consultation_method" value="対面" <?= $consultation_method === '対面' ? 'checked' : '' ?>>
    <label for="in_person">対面</label>
    <br>

    <label for="learning_languages">学習言語 ※ : </label>
    <input type="checkbox" id="python" name="learning_languages[]" value="Python" <?= in_array('Python', $learning_languages) ? 'checked' : '' ?>>
    <label for="python">Python</label>
    <input type="checkbox" id="javascript" name="learning_languages[]" value="JavaScript" <?= in_array('JavaScript', $learning_languages) ? 'checked' : '' ?>>
    <label for="javascript">JavaScript</label>
    <input type="checkbox" id="php" name="learning_languages[]" value="PHP" <?= in_array('PHP', $learning_languages) ? 'checked' : '' ?>>
    <label for="php">PHP</label>
    <input type="checkbox" id="java" name="learning_languages[]" value="Java" <?= in_array('Java', $learning_languages) ? 'checked' : '' ?>>
    <label for="java">Java</label>
    <input type="checkbox" id="csharp" name="learning_languages[]" value="C#" <?= in_array('C#', $learning_languages) ? 'checked' : '' ?>>
    <label for="csharp">C#</label>
    <input type="checkbox" id="ruby" name="learning_languages[]" value="Ruby" <?= in_array('Ruby', $learning_languages) ? 'checked' : '' ?>>
    <label for="ruby">Ruby</label>
    <input type="checkbox" id="go" name="learning_languages[]" value="Go" <?= in_array('Go', $learning_languages) ? 'checked' : '' ?>>
    <label for="go">Go</label>
    <input type="checkbox" id="cplus" name="learning_languages[]" value="C++" <?= in_array('C++', $learning_languages) ? 'checked' : '' ?>>
    <label for="cplus">C++</label>
    <input type="checkbox" id="another" name="learning_languages[]" value="その他" <?= in_array('その他', $learning_languages) ? 'checked' : '' ?>>
    <label for="another">その他</label>
    <br>

    <label for="os_env">OS環境 : </label>
    <input type="radio" id="windows" name="os_env" value="Windows" <?= $os_env === 'Windows' ? 'checked' : '' ?>>
    <label for="windows">Windows</label>
    <input type="radio" id="mac" name="os_env" value="macOS" <?= $os_env === 'macOS' ? 'checked' : '' ?>>
    <label for="mac">macOS</label>
    <input type="radio" id="linux" name="os_env" value="Linux" <?= $os_env === 'Linux' ? 'checked' : '' ?>>
    <label for="linux">Linux</label>
    <br>

    <label for="consultation_categories">相談カテゴリー ※ : </label>
    <input type="checkbox" id="error" name="consultation_categories[]" value="エラー解決" <?= in_array('エラー解決', $consultation_categories) ? 'checked' : '' ?>>
    <label for="error">エラー解決</label>
    <input type="checkbox" id="design" name="consultation_categories[]" value="設計相談" <?= in_array('設計相談', $consultation_categories) ? 'checked' : '' ?>>
    <label for="design">設計相談</label>
    <input type="checkbox" id="learning" name="consultation_categories[]" value="学習方法" <?= in_array('学習方法', $consultation_categories) ? 'checked' : '' ?>>
    <label for="learning">学習方法</label>
    <input type="checkbox" id="career" name="consultation_categories[]" value="キャリア相談" <?= in_array('キャリア相談', $consultation_categories) ? 'checked' : '' ?>>
    <label for="career">キャリア相談</label>
    <input type="checkbox" id="review" name="consultation_categories[]" value="レビュー" <?= in_array('レビュー', $consultation_categories) ? 'checked' : '' ?>>
    <label for="review">コードレビュー</label>
    <input type="checkbox" id="other" name="consultation_categories[]" value="その他" <?= in_array('その他', $consultation_categories) ? 'checked' : '' ?>>
    <label for="other">その他</label>
    <br>

    <div class="range-area">
    <label for="details">相談内容の詳細 ※ : </label>
    <textarea id="details" name="details" rows="5" cols="40" placeholder="〇〇のエラーが出ており、△△を試しましたが解決しません"><?= h($details) ?></textarea>
    </div>
    <br>

  <div class="range-area">
    <label for="urgency_level">緊急度（対応の優先度）：<span id="urgencyValue"><?= h($urgency_level) ?></span></label>
    <!-- スライダー本体 -->
    <input type="range" id="urgency_level" name="urgency_level" min="1" max="5" step="1" value="<?= h($urgency_level) ?>">
    
    <!-- 目盛りラベル -->
    <div class="range-labels">
      <span>1<br>低</span>
      <span>2</span>
      <span>3<br>普通</span>
      <span>4</span>
      <span>5<br>高</span>
    </div>
  </div>

  <br>
  <br>

  <label for="privacy_policy_accepted">プライバシーポリシーに同意する(必須) : </label>
  <input type="checkbox" id="privacy_policy_accepted" name="privacy_policy_accepted" value="1">
  <br>
  <label for="terms_accepted">利用規約に同意する(必須) : </label>
  <input type="checkbox" id="terms_accepted" name="terms_accepted" value="1">
  <br>
  <label for="data_usage_accepted">データ利用に同意する(必須) : </label>
  <input type="checkbox" id="data_usage_accepted" name="data_usage_accepted" value="1">
  <br>
  <label for="cancellation_policy_accepted">当日のキャンセルポリシーに同意する(必須) : </label>
  <input type="checkbox" id="cancellation_policy_accepted" name="cancellation_policy_accepted" value="1">  
  <br>
  <input type="submit" value="確認">
  </form>

</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
  <!-- スライダーの値をリアルタイムで表示するためのJavaScript -->
   $('#urgency_level').on('input', function() {
    $('#urgencyValue').text(this.value);
  });

  <!-- フォームのバリデーションチェック -->
  function validateForm() {

    // エラーを格納する配列
    let errors = [];

    // 必須項目のチェック
    if (!$('#name').val()) {
      errors.push('お名前は必須項目です。');
  }
    if (!$('#email').val()) {
      errors.push('メールアドレスは必須項目です。');
    }
    if (!$('#reservation_date').val()) {
      errors.push('予約日は必須項目です。');
    }
    if (!$('#reservation_time').val()) {
      errors.push('予約時間は必須項目です。');
    }
    if (!$('input[name="consultation_method"]:checked').val()) {
      errors.push('相談方法は必須項目です。');
    }
    if ($('input[name="learning_languages[]"]:checked').length === 0) {
      errors.push('学習言語は必須項目です。');
    }
    if ($('input[name="consultation_categories[]"]:checked').length === 0) {
      errors.push('相談カテゴリーは必須項目です。');
    }
    if (!$('#details').val()) {
      errors.push('相談内容の詳細は必須項目です。');
    }

    // 同意事項のチェック
    if (! $('#privacy_policy_accepted').is(':checked')) {
      errors.push('プライバシーポリシーに同意する必要があります。');
    }
    if (! $('#terms_accepted').is(':checked')) {
      errors.push('利用規約に同意する必要があります。');
    }
    if (! $('#data_usage_accepted').is(':checked')) {
      errors.push('データ利用に同意する必要があります。');
    }
    if (! $('#cancellation_policy_accepted').is(':checked')) {
      errors.push('当日のキャンセルポリシーに同意する必要があります。');
    }

    // エラーがある場合はアラートを表示
    if (errors.length > 0) {
      // アラート表示
      alert(errors.join('\n'));
      // 赤文字表示
      $('#errorMessages').html(errors.join('<br>'));
      return false;
    }

    // すべてのチェックが通った場合はフォームを送信
    return true;
  }
</script>
</html>