<?php

session_start();

require_once '../classes/UserLogic.php';

//ログインしていたら、signup_formを開けないようにする。
$result = UserLogic::checkLogin();
if($result){
  header('Location: mypage.php'); //true（ログインしていた）場合は、mypageに戻す
  return;
}

$err = $_SESSION;

//セッションを消す
//28・38行目でエラー表示をするが、リロードしたらエラーを消す
$_SESSION = array();
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
</head>
<body>
<h2>ログインフォーム</h2>
   <!-- もしエラーがあったらメッセージを表示 -->
    <?php if (isset($err['msg'])) : ?>
    <p><?php echo $err['msg']; ?></p>
    <?php endif; ?>


<form action="login.php" method="POST">

<p>
  <label for="email">メールアドレス：</label>
  <input type="email" name="email">

   <!-- もしエラーがあったらメッセージを表示。4行目で指定してる -->
    <?php if (isset($err['email'])) : ?>
    <p><?php echo $err['email']; ?></p>
    <?php endif; ?>
</p>

<p>
  <label for="password">パスワ―ド：</label>
  <input type="password" name="password">

   <!-- もしエラーがあったらメッセージを表示。4行目で指定してる -->
    <?php if (isset($err['password'])) : ?>
    <p><?php echo $err['password']; ?></p>
    <?php endif; ?>

</p>

<p>
  <input type="submit" value="ログイン">
</p>

</form>
<a href="signup_form.php">新規登録はこちら</a>

</body>
</html>