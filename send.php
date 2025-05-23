<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// サニタイズ関数
function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 応募者のメールアドレス
$user_email = $_POST['email'];

// 管理者宛メール
$admin_to = "your-address@example.com"; // ←あなたのメールアドレスに変更
$admin_subject = "【エントリーフォーム】応募がありました";
$admin_body = <<<EOT
以下の内容で応募がありました。

【お名前】 {$_POST['name']}
【フリガナ】 {$_POST['kana']}
【生年月日】 {$_POST['birth_year']}年 {$_POST['birth_month']}月 {$_POST['birth_day']}日
【性別】 {$_POST['gender']}
【郵便番号】 {$_POST['zip']}
【住所】 {$_POST['address']}
【電話番号】 {$_POST['tel']}
【メールアドレス】 {$_POST['email']}
【最終学歴】 {isset($_POST['education']) ? implode(', ', $_POST['education']) : ''}
【卒業(見込)学校名】 {$_POST['school']}
【現在の勤務先】 {$_POST['company']}
【自己PR】
{$_POST['pr']}
EOT;

$admin_headers = "From: {$_POST['email']}";

// 応募者宛の自動返信メール
$user_subject = "【自動返信】ご応募ありがとうございました";
$user_body = <<<EOT
{$_POST['name']} 様

このたびはエントリーフォームよりご応募いただき、誠にありがとうございます。
以下の内容で受け付けいたしました。

＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

【お名前】 {$_POST['name']}
【フリガナ】 {$_POST['kana']}
【生年月日】 {$_POST['birth_year']}年 {$_POST['birth_month']}月 {$_POST['birth_day']}日
【性別】 {$_POST['gender']}
【郵便番号】 {$_POST['zip']}
【住所】 {$_POST['address']}
【電話番号】 {$_POST['tel']}
【メールアドレス】 {$_POST['email']}
【最終学歴】 {isset($_POST['education']) ? implode(', ', $_POST['education']) : ''}
【卒業(見込)学校名】 {$_POST['school']}
【現在の勤務先】 {$_POST['company']}
【自己PR】
{$_POST['pr']}

＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

担当者より改めてご連絡させていただきますので、しばらくお待ちください。

------------------------------------------------------------
※このメールは自動返信です。ご返信は不要です。
------------------------------------------------------------

EOT;

$user_headers = "From: {$admin_to}";

// 送信処理
$admin_result = mb_send_mail($admin_to, $admin_subject, $admin_body, $admin_headers);
$user_result  = mb_send_mail($user_email, $user_subject, $user_body, $user_headers);

// 送信結果
if ($admin_result && $user_result) {
  echo "送信が完了しました。ありがとうございました。";
} else {
  echo "送信に失敗しました。";
}
