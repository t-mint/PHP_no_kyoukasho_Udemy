<?php
session_start();
// DB接続設定を読み込む
require('../dbconnect.php');

// isset：変数の存在チェック（存在してかつ値があるか）
if(!isset($_SESSION['join'])) {
	header('Location: index.php');
	exit();
}
// ページ内で登録ボタンが押されたら（＝POSTが空でなければ）
if (!empty($_POST)) {
	// DBに登録するためのSQL文をプレースホルダーにして作成
	$statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, picture=?, created=NOW()');
	// プレースホルダーにセッションの値をセットして登録実行
	// sha1()：ハッシュ関数、DBに登録されたパスワードは非可逆暗号化される
	$statement->execute(array(
		$_SESSION['join']['name'], 
		$_SESSION['join']['email'], 
		sha1($_SESSION['join']['password']), 
		$_SESSION['join']['image']
	));
	// unset：変数を削除する
	// 使い終わった不要なセッション変数をすぐに削除している
	unset($_SESSION['join']);

	// 登録完了ページに遷移
	header('Location: thanks.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>会員登録</h1>
</div>

<div id="content">
<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
<form action="" method="post">
	<!-- 登録ボタンを押したかどうかの判定用にhddenでsubmitをセットしてる -->
	<input type="hidden" name="action" value="submit" />
	<dl>
		<dt>ニックネーム</dt>
		<dd>
		<?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?>
        </dd>
		<dt>メールアドレス</dt>
		<?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?>
		<dd>
        </dd>
		<dt>パスワード</dt>
		<dd>
		【表示されません】
		</dd>
		<dt>写真など</dt>
		<dd>
		<!-- セッションに画像のファイル名があれば -->
		<?php if ($_SESSION['join']['image'] != ''): ?>
			<!-- index.phpで保存しているはずの画像の保存先＋ファイル名を指定して表示する -->
			<img src="../member_picture/<?php print(htmlspecialchars($_SESSION['join']['image'], ENT_QUOTES)); ?>">
		<?php endif; ?>
		</dd>
	</dl>
	<!-- ブラウザバックされないように書き戻しリンクを用意して、印のパラメータを付加してindex.phpに戻してる -->
	<div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
</form>
</div>

</div>
</body>
</html>
