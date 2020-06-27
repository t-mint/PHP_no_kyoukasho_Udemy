<?php 
session_start();
// DB接続設定を読み込む
require('dbconnect.php');

// クッキーに値が保存されていたとき
if ($_COOKIE['email'] !== '') {
  // クッキーの値をフォームのメアド欄表示用変数にセット
  $email = $_COOKIE['email'];
}
// ログインボタンを押したなら（POSTが空でない）
if (!empty($_POST)) {
  // POSTが空でないので、フォームのメアド欄表示用変数にPOSTのメアドをセット
  $email = $_POST['email'];
  // フォームに入力した値が空でなければ
  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    // SELECT文でDBからメアドとパスワードをプレースホルダーにして参照する
      $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
      // プレースホルダーにフォームに入力した値をセット
      // パスワードはDB登録時にsha1でハッシュ化しているので、取り出す時もハッシュ化しないとパスワード不一致になる
      $login->execute(array($_POST['email'], sha1($_POST['password'])));
      // SELECT文の実行結果を取得
      $member = $login->fetch();
      // 実行結果があれば（fetchで取得できていればTRUEなので）
      if ($member) {
        // セッションに登録IDとログイン開始時間を記録しておく
        $_SESSION['id'] = $member[id];
        $_SESSION['time'] = time();

        // 自動的にログインチェックボックスがONであれば
        if ($_POST['save'] === 'on') {
          // クッキーにログイン情報を保存する
          // setcookie：
          //    第1引数はクッキーID名（$_COOKIE['ID名']）、第2引数は保存する値
          //    第3引数は有効期限を設定している。ここでは今日の日付から１４日間
          setcookie('email', $_POST['email'], time()+60*60*24*14);
        }
        // トップページに遷移させる
        header('Location: index.php');
        exit();
      } else {
        // ログイン情報不一致のため、エラー変数をセット
        $error['login'] = 'failed';
      }
  } else {
    // フォームの入力内容が空であるため、エラー変数をセット
    $error['login'] = 'blank';
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ログインする</title>
</head>

<body>
<div id="wrap">
  <div id="head">
    <h1>ログインする</h1>
  </div>
  <div id="content">
    <div id="lead">
      <p>メールアドレスとパスワードを記入してログインしてください。</p>
      <p>入会手続きがまだの方はこちらからどうぞ。</p>
      <p>&raquo;<a href="join/">入会手続きをする</a></p>
    </div>
    <form action="" method="post">
      <dl>
        <dt>メールアドレス</dt>
        <dd>
          <!-- valueの$emailはフォームのメアド欄表示用変数で、
                クッキーの値（$_COOKIE['email']）OR ログインボタン押下前の値（$_POST['email']）が入っている -->
          <input type="text" name="email" size="35" maxlength="255" value="<?php print(htmlspecialchars($email, ENT_QUOTES)); ?>" />
          <?php if ($error['login'] === 'blank'): ?>
            <p class="error">*メールアドレスとパスワードをご記入ください</p>
          <?PHP endif; ?>
          <?php if ($error['login'] === 'failed'): ?>
            <p class="error">*ログインに失敗しました。ただしくご記入ください</p>
          <?PHP endif; ?>
        </dd>
        <dt>パスワード</dt>
        <dd>
          <input type="password" name="password" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
        </dd>
        <dt>ログイン情報の記録</dt>
        <dd>
          <input id="save" type="checkbox" name="save" value="on">
          <label for="save">次回からは自動的にログインする</label>
        </dd>
      </dl>
      <div>
        <input type="submit" value="ログインする" />
      </div>
    </form>
  </div>
  <div id="foot">
    <p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
  </div>
</div>
</body>
</html>
