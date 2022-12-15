<?php

//データベースへの登録が必要となるため、dbconnectを読み込む
require_once '../dbconect.php';

//エラー表示をするコード
ini_set('display_errors', true);


//クラスを指定する
class UserLogic
{
  /** PHPdoc 説明
   * ユーザを登録する
   * @param array @userData 
   * @return bool $result
  */
public static function createUser($userData)
{
    $result = false;

    $sql = 'INSERT INTO users (name, email,
    password) VALUES(?, ?, ?)';

  // VALUES (?, ?, ?)には、ユーザデータを配列に入れる
  $arr = [];
  $arr[] = $userData['username'];
  $arr[] = $userData['email'];
  $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

  //データベースは例外処理も必ず入れる
  try{
  //sqlを実行する
    $stmt = connect()->prepare($sql);
    $result = $stmt->execute($arr); //上手く処理が行けば、15行目のfalseがここの$resultでtrueに変わる
    return $result;
  } catch(\Exception $e){ //例外が発生した場合の処理
    // resultを返す。
    return $result; //上手くいかなければfolseのまま
  }
}

  /** PHPdoc 
   * ログイン処理
   * @param array @email
   * @return bool $password
   * @return bool $result
  */
  public static function login($email, $password)
  {
    //結果
    $result = false;
    //ユーザーをemailから検索して取得
    $user = self::getUserByEmail($email);
    
    //emailが違った場合の処理
    if (!$user){
      $_SESSION['msg'] = 'emailが一致しません。';
      return $result;
    }

    //パスワードの照会
    if(password_verify($password, $user['password'])){
    //ログイン成功した後
    session_regenerate_id(true); //古いセッションを破棄して新しいセッションを創る
    $_SESSION['login_user']= $user;
    $result = true;
    return $result;
    }

    //パスワードが違った場合の処理
    $_SESSION['msg'] = 'パスワードが一致しません。';
    return $result;
    

  }
  
  /** PHPdoc 
   * emailからユーザを取得
   * @param array @email
   * @return array|bool $user|false
  */
  public static function getUserByEmail($email)
  {
    //SQLの準備
    //SQLの実行
   //SQLの結果を返す
  $sql = 'SELECT * FROM users WHERE email = ? ';

  // emailを配列に入れる
  $arr = [];
  $arr[] = $email;

  //データベースは例外処理も必ず入れる
  try{
  //sqlを実行する
    $stmt = connect()->prepare($sql);
    $stmt->execute($arr); 
    //sqlの結果を返す
    $user = $stmt->fetch();
    return $user;
  } catch(\Exception $e){ //例外が発生した場合の処理
    return false; 
  }
}

  /** PHPdoc 
   * ログインチェック
   * @param void
   * @return bool $result
  */
  public static function checkLogin()
  {
    $result = false;

  //セッションにログインユーザーが入っていなかったらfalse
  if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
    return $result = true;
  }
    return $result;
  }

/**ログアウト処理
 * 
 * 
 */
public static function logout()
{
 $_SESION = array();
 session_destroy();
  
}


}
