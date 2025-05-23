<?php
// 入力チェック（最低限の確認）
$required = ['name', 'kana', 'birth_year', 'birth_month', 'birth_day', 'gender', 'email', 'email_confirm'];
foreach ($required as $field) {
  if (empty($_POST[$field])) {
    exit('必須項目が未入力です。<a href="form.html">戻る</a>');
  }
}

// メール確認一致チェック
if ($_POST['email'] !== $_POST['email_confirm']) {
  exit('メールアドレスが一致しません。<a href="form.html">戻る</a>');
}

// エスケープ処理関数
function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 複数選択の処理
$education = isset($_POST['education']) ? implode(', ', $_POST['education']) : '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>確認画面</title>
</head>
<body>
  <h1>確認画面</h1>

  <form action="send.php" method="post">
    <p>お名前：<?php echo h($_POST['name']); ?></p>
    <p>フリガナ：<?php echo h($_POST['kana']); ?></p>
    <p>生年月日：<?php echo h($_POST['birth_year']) . '年 ' . h($_POST['birth_month']) . '月 ' . h($_POST['birth_day']) . '日'; ?></p>
    <p>性別：<?php echo h($_POST['gender']); ?></p>
    <p>郵便番号：<?php echo h($_POST['zip']); ?></p>
    <p>ご住所：<?php echo h($_POST['address']); ?></p>
    <p>お電話番号：<?php echo h($_POST['tel']); ?></p>
    <p>メールアドレス：<?php echo h($_POST['email']); ?></p>
    <p>最終学歴：<?php echo h($education); ?></p>
    <p>卒業（見込）学校名：<?php echo h($_POST['school']); ?></p>
    <p>現在（直近）の勤務先：<?php echo h($_POST['company']); ?></p>
    <p>自己PR：<br><?php echo nl2br(h($_POST['pr'])); ?></p>

    <?php foreach ($_POST as $key => $value): ?>
      <?php if (is_array($value)): ?>
        <?php foreach ($value as $v): ?>
          <input type="hidden" name="<?php echo h($key); ?>[]" value="<?php echo h($v); ?>">
        <?php endforeach; ?>
      <?php else: ?>
        <input type="hidden" name="<?php echo h($key); ?>" value="<?php echo h($value); ?>">
      <?php endif; ?>
    <?php endforeach; ?>

    <p>
      <button type="submit">送信する</button>
      <button type="button" onclick="history.back();">戻る</button>
    </p>
  </form>
</body>
</html>
