<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員情報変更</title>

	<link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>会員情報変更</h1>
</div> 

<?php
session_start();
require('dbconnect.php');

if(!isset($_SESSION['join'])){
    header('Location: index.php');
    exit();
}

if(!empty($_POST)){
    //登録情報を変更する
	// DBに登録するためのSQL文をプレースホルダーにして作成
	$statement = $db->prepare('UPDATE members SET name=?, email=?, password=?, picture=?, created=NOW() WHERE id=?');
	// プレースホルダーにセッションの値をセットして登録実行
	// sha1()：ハッシュ関数、DBに登録されたパスワードは非可逆暗号化される
	$statement->execute(array(
		$_SESSION['join']['name'], 
		$_SESSION['join']['email'], 
		sha1($_SESSION['join']['password']), 
		$_SESSION['join']['image'],
		$_SESSION['id']
	));
	// unset：変数を削除する
	// 使い終わった不要なセッション変数をすぐに削除している
	unset($_SESSION['join']);

	// 登録完了ページに遷移
	header('Location: join/thanks.php?kind=update');
	exit();

}
?>
<div id="content">
<p>登録内容の確認</p>
<form action="" method="post">
    <input type="hidden" name="action" value="submit" />
    <dl>
        <dt>ニックネーム</dt>
        <dd>
            <?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES, 'UTF-8'); ?>
        </dd>

        <dt>メールアドレス</dt>
        <dd>
            <?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES, 'UTF-8'); ?>
        </dd>

        <dt>パスワード</dt>
        <dd>
            【表示されません】
        </dd>

        <dt>写真など</dt>
        <dd>
            <img src="member_picture/<?php echo htmlspecialchars($_SESSION['join']['image'], ENT_QUOTES, 'UTF-8'); ?>
            " width="100" height="100" alt="" />
        </dd>
    </dl>
    <div><p><a href="change_input.php?action=rewrite">&laquo;&nbsp;書き直す</a></p>
    <br>
    <input type="submit" value="変更する"/></div>
</form>

</body>
</html>
