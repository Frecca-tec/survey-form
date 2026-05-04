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
  <form method="post" action="confirm.php">
    <label for="name">お名前 ※ : </label>
    <input type="text" id="name" name="name" placeholder="例：山田太郎">
    <br>
    <label for="email">メールアドレス ※ : </label>
    <input type="email" id="email" name="email">
    <br>
    <label for="telephone">電話番号(任意) : </label>
    <input type="tel" id="telephone" name="telephone">
    <br>
    <label for="reservation_date">予約日 ※ : </label>
    <input type="date" id="reservation_date" name="reservation_date">
    <br>
    <label for="reservation_time">予約時間 ※ : </label>
    <input type="time" id="reservation_time" name="reservation_time">
    <br>
    <label for="consultation_method">相談方法 ※ : </label>
    <input type="radio" id="online" name="consultation_method" value="オンライン">
    <label for="online">オンライン（Zoom）</label>
    <input type="radio" id="phone" name="consultation_method" value="電話">
    <label for="phone">電話</label>
    <input type="radio" id="email_method" name="consultation_method" value="メール">
    <label for="email_method">メール</label>
    <input type="radio" id="chat" name="consultation_method" value="チャット">
    <label for="chat">チャット</label>
    <input type="radio" id="in_person" name="consultation_method" value="対面">
    <label for="in_person">対面</label>
    <br>
    <label for="learning_languages">学習言語 ※ : </label>
    <input type="checkbox" id="python" name="learning_languages[]" value="Python">
    <label for="python">Python</label>
    <input type="checkbox" id="javascript" name="learning_languages[]" value="JavaScript">
    <label for="javascript">JavaScript</label>
    <input type="checkbox" id="php" name="learning_languages[]" value="PHP">
    <label for="php">PHP</label>
    <input type="checkbox" id="java" name="learning_languages[]" value="Java">
    <label for="java">Java</label>
    <input type="checkbox" id="csharp" name="learning_languages[]" value="C#">
    <label for="csharp">C#</label>
    <input type="checkbox" id="ruby" name="learning_languages[]" value="Ruby">
    <label for="ruby">Ruby</label>
    <input type="checkbox" id="go" name="learning_languages[]" value="Go">
    <label for="go">Go</label>
    <input type="checkbox" id="cplus" name="learning_languages[]" value="C++">
    <label for="cplus">C++</label>
    <input type="checkbox" id="swift" name="learning_languages[]" value="その他">
    <label for="swift">その他</label>
    <br>
    <label for="os_env">OS環境 : </label>
    <input type="radio" id="windows" name="os_env" value="Windows">
    <label for="windows">Windows</label>
    <input type="radio" id="mac" name="os_env" value="macOS">
    <label for="mac">macOS</label>
    <input type="radio" id="linux" name="os_env" value="Linux">
    <label for="linux">Linux</label>
    <br>
    <label for="consultation_categories">相談カテゴリ ※ : </label>
    <input type="checkbox" id="error" name="consultation_categories[]" value="エラー解決">
    <label for="error">エラー解決</label>
    <input type="checkbox" id="design" name="consultation_categories[]" value="設計相談">
    <label for="design">設計相談</label>
    <input type="checkbox" id="learning" name="consultation_categories[]" value="学習方法">
    <label for="learning">学習方法</label>
    <input type="checkbox" id="career" name="consultation_categories[]" value="キャリア相談">
    <label for="career">キャリア相談</label>
    <input type="checkbox" id="review" name="consultation_categories[]" value="レビュー">
    <label for="review">コードレビュー</label>
    <input type="checkbox" id="other" name="consultation_categories[]" value="その他">
    <label for="other">その他</label>
    <br>
    <div class="range-area">
    <label for="details">相談内容の詳細 ※ : </label>
    <textarea name="details" rows="5" cols="40" placeholder="〇〇のエラーが出ており、△△を試しましたが解決しません"></textarea>
    </div>
    <br>

  <div class="range-area">
    <label for="urgency_level">緊急度（対応の優先度）：<span id="urgencyValue">3</span></label>
    <!-- スライダー本体 -->
    <input type="range" id="urgency_level" name="urgency_level" min="1" max="5" step="1" value="3">
    
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
</html>