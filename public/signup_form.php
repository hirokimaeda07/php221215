<?php

session_start();

require_once '../functions.php';
require_once '../classes/UserLogic.php';

//ログインしていたら、signup_formを開けないようにする。
$result = UserLogic::checkLogin();
if($result){
  header('Location: mypage.php'); //true（ログインしていた）場合は、mypageに戻す
  return;
}

//三項演算子。if意外の書き方。
$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録画面</title>
</head>
<body>
  <h2>ユーザー登録フォーム</h2>
   <!-- もしエラーがあったらメッセージを表示 -->
    <?php if (isset($login_err)) : ?>
    <p><?php echo $login_err; ?></p>
    <?php endif; ?>

  <form action="register.php" method="POST">
  <p>
    <label for="username">ユーザー名：</label>
    <input type="text" name="username">
  </p>
  <p>
    <label for="email">メールアドレス：</label>
    <input type="email" name="email">
  </p>
  <p>
    <label for="password">パスワード：</label>
    <input type="password" name="password">
  </p>
  <p>
    <label for="password_conf">パスワード確認：</label>
    <input type="password" name="password_conf">
  </p>

<!-- 新規登録を押すと、xsrf_tokenも送られる -->
<input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">

  <p>
    <input type="submit" value="新規登録">
  </p>

</form>
<a href="login_form.php">ログインする</a>  

</body>
</html>