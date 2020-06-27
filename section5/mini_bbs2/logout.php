<?php
session_start();

// セッションの情報を削除するので空の配列で上書きする
$_SESSION = array();
// セッションにクッキーを使うか？決まり文句みたいなものとのこと（わからん）
if (ini_set('session.use_cookies')) {
    // 以降はクッキーの情報を削除するための情報
    $params = session_get_cookie_params();
    setcookie(
            // クッキーの有効期限を切る
            session_name(). '', time() - 4200, 
            // session_get_cookieが返してきた値をそれぞれ設定して、
            // セッションのクッキーが使っているオプションを指定している？
            // これによってセッションの使ったクッキーが削除される（わからん）
            $params['path'], 
            $params['domain'], 
            $params['secure'], 
            $params['httponly']
    );
}
// 最後にセッションデストロイでセッションを完全に消している
session_destroy();

// クッキーに保存されているメールアドレスを削除（ログイン画面で記憶されていたやつ）
setcookie('email', '', time() - 3600);

header('Location: login.php');
exit();
?>