<?php

session_start();
require_once '../classes/UserLogic.php';

//!$logoutの、！は$logoutが無かったらという意味
if(!$logout = filter_input(INPUT_POST, 'logout')){
  exit('不正なリクエストです。');
}

//ログインしているか判定し、セッションがきれていたらログインしてくださいとメッセージをだす。
//PHPのセッションの有効期限は24分、それ以降はセッションが切れる。
$result = UserLogic::checkLogin();

if(!$result){
  exit('セッションがきれましたので、ログインし直してください。');
}

//ログアウトする
UserLogic::logout();

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログアウト</title>
</head>
<body>
<h2>ログアウト完了</h2>
<p>ログアウトしました</p>
<a href="login_form.php">ログイン画面へ</a>

</body>
</html>