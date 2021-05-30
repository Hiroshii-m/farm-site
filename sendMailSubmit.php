<?php
// メール送信
$from = 'karinoaca3@gmail.com';
$to = $_SESSION['email'];
$subject = '【ユーザー登録】| ノウハン';
$url = $_SERVER['HTTP_HOST'].'/output2/farm/tokenRecieve.php?token='.$token;
$comment = <<<EOT
ノウハンをご利用いただきありがとうございます。
    
以下のURLをクリックして、ユーザー登録を完了してください。
{$url}
    
    
*認証キーの有効期限は24時間です。
    
*このメールは返信しても届きません。お問い合わせは、本サイト下部の「お問い合わせ」からお願いいたします。
    
■ご登録の覚えがないのにこのメールが届いたという方
ご迷惑をおかけし申し訳ありません。大変お手数ですが、下記のメールアドレスまでご連絡をお願いいたします。
support@******.jp
    
EOT;
    
sendMail($from, $to, $subject, $comment);