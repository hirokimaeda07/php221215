<?php

//sessionIDを入れる
session_start();

require_once '../classes/UserLogic.php';

//エラー表示をするコード
ini_set('display_errors', true);


//エラーメッセージ
$err = [];

//バリデーション
if(!$email = filter_input(INPUT_POST, 'email')){
  $err['email'] = 'メールアドレスを記入してください！';
}

if(!$password = filter_input(INPUT_POST, 'password')){
  $err['password'] = 'パスワードを記入してください！';
}


//エラーが有った場合には、login.phpに戻してエラーを表示する処理
if(count($err) > 0) {
  
  $_SESSION = $err;
  //エラーが有れば,login.php戻す
  header('Location: login_form.php');
  return;
}
//ログイン成功時の処理
$result = UserLogic::login($email, $password);
//ログインエラー時の処理
if(!$result){
  header('Location: login_form.php');
  return;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン完了</title>
</head>
<body>
<h2>ログイン完了</h2>
<p>ログインしました！</p>
<a href="./mypage.php">マイページ</a>

</body>
</html>