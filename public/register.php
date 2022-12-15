<?php

session_start();

require_once '../classes/UserLogic.php';

//エラー表示をするコード
ini_set('display_errors', true);

//エラーメッセージ
$err = [];

$token = filter_input(INPUT_POST, 'csrf_token')
//トークンがない、もしくは一致しない場合、処理を注意
if (!isset($_SESSION['cdrf_token']) || $token !== $_SESSION['csrf_token']){
  exit('不正なリクエスト');
}
//セッションを消す。2重送信を防止する、不正なリクエストの対策。
unset($_SESSION['csrf_token']);


//バリデーション
//signuu_form.phpの　name="username"がPOSTで送られてきたら受け取れる。
//ifを付けることで、もしusernameが空欄なら、$err[]の処理をするしていが可能。
if(!$username = filter_input(INPUT_POST, 'username')){
  $err[] = 'ユーザ名を記入してください！';
}
if(!$email = filter_input(INPUT_POST, 'email')){
  $err[] = 'メールアドレスを記入してください！';
}
//パスワードのバリデーションは、正規表現でおこなう。
$password = filter_input(INPUT_POST, 'password');
///\A[a-z\d]{8,20}　は、パスワードが8文字以上、100文字以下の場合、もしくは英数字が含まれていればOKとするもの。
//これだけだとパスワードのセキュリティは弱いからだめ。大文字₊小文字にしないとだめとか細かな指定が必要。
if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){
 $err[] = 'パスワードは英数字8文字以上100文字以下にしてください。';
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
// $passwordと異なっていたら、エラーを表示する
if($password !== $password_conf){
  $err[] = '確認用パスワードと異なっています。';
}

//もし上記でerrが出ないなら（問題ないなら）処理するけど、エラーがあれば処理はスルーされて、44行目にいく。
if(count($err) === 0) {
  //ユーザを登録する処理は、別のページ（UserLogic.php）記載する
  //クラス:UserLogic　メゾッド:createUser
  $hasCreated = UserLogic::createUser($_POST);

  if(!$hasCreated){
    $err[] = '登録に失敗しました';
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザ登録完了画面</title>
</head>
<body>
  <!-- もしerrがあるならここにエラーメッセージを表示する -->
  <?php if (count($err) > 0) : ?>
    <?php foreach($err as $e) : ?>
      <p><?php echo $e ?></p>
    <?php endforeach ?>

  <!-- それ以外（エラーがなければ）、ユーザー登録を完了する -->
  <?php else : ?>
    <p>ユーザ登録が完了しました！</p>
  <?php endif ?>

  <a href="./signup_form.php">戻る</a>
</body>
</html>