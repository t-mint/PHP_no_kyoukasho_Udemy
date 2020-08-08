<?php
session_start();
// DB接続設定を読み込む
require('../dbconnect.php');

// 初期表示ではエラーを発生しないようにするために、POSTが空っぽの時は初期表示と判定してエラーチェックを行わない
if (!empty($_POST)) {
	// バリデーションチェック
	// ニックネーム、メールアドレス、パスワード欄
	if ($_POST['name'] === '') {
		// 未入力ならエラー判定用変数にエラーフラグをセット
		$error['name'] = 'blank';
	}
	if ($_POST['email'] === '') {
		// 未入力ならエラー判定用変数にエラーフラグをセット
		$error['email'] = 'blank';
	}
	// strlenメソッド：文字数を返す
	if (strlen($_POST['password']) < 4) {
		// 4文字以下ならエラー判定用変数にエラーフラグをセット
		$error['password'] = 'length';
	}
	if ($_POST['password'] === '') {
		// 未入力ならエラー判定用変数にエラーフラグをセット
		$error['password'] = 'blank';
	}
	// アップロードされたファイル名を一旦変数に保存
	$fileName = $_FILES['image']['name'];
	if (!empty($fileName)) {
		// substr：第二引数の「-3」でファイル名の後ろ3文字（拡張子部分）を切り取っている
		$ext = substr($fileName, -3);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
			// 拡張子が画像ファイルでなければエラー判定用変数にエラーフラグをセット
			$error['image'] = 'type';
		}
	}

	// アカウントの重複チェック
	if(empty($error)) {
		// membersテーブルに登録されているメアドがフォームで入力したメアドと同じかをcountで数えて比較
		$member = $db->prepare('SELECT COUNT(*) AS cut FROM members WHERE email=?');
		// プレースホルダーには入力したメアドをセット（WHERE条件に入る）
		$member->execute(array($_POST['email']));
		// SELECT文でカウントされた結果をfetchで取り出してる
		$record = $member->fetch();
		// カウント数が1以上なら重複（すでにDBに登録がある）ことになるのでエラー変数をセットしている
		if ($record['cut'] > 0) {
			$error['email'] = 'duplicate';
		}
	}

	// emptyメソッド：配列が空っぽであればTRUEを返す
	// エラーでなければ、ファイルピッカーで選択したファイルのアップロード処理
	if (empty($error)){
		// date('YmdHis')：アップロードするファイル名が重複しないように年月日時分秒を付加している
		// $_FILES：input type="file"～のフィールドから取得した内容が入ってる。
		$image = date('YmdHis'). $_FILES['image']['name'];
		// move_uploaded_file：取得したファイルを保存する
		// 引数１：$_FILES['image']['tmp_name']：一時的なファイル名として取得されたファイル名
		// 引数２：保存先ディレクトリ＋任意に指定したファイル名
		move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/'. $image);
		// 入力内容（名前・メアド・パス）をセッションに保存
		$_SESSION['join'] = $_POST;
		// ファイル名をセッションに保存
		$_SESSION['join']['image'] = $image;
		// 確認画面へ遷移
		header('Location: check.php');
		exit();
	}
}

// check.phpから「書き戻す」リンクで戻ってきた時（パラメータで判断してる）
if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
	// check.phpでセッションに入れた時の値をポスト用の変数に戻している
	// つまり、index.phpで入力した値をPOST →（確認ボタン） → check.phpでSESIONに入れて表示 → （書き戻すボタン） → index.phpでSESSIONを再度POST用変数に代入
	$_POST = $_SESSION['join'];
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
<p>次のフォームに必要事項をご記入ください。</p>
<!-- enctype：ファイルのアップロードが必要な場合に付加する -->
<form action="" method="post" enctype="multipart/form-data">
	<dl>
		<dt>ニックネーム<span class="required">必須</span></dt>
		<dd>
			<!--  -->
			<input type="text" name="name" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['name'])); ?>" />
			<?php if ($error['name'] === 'blank'): ?>
				<!-- class="error"にしてるのはCSSで文字を赤くする定義をしてあるため -->
				<p class="error">* ニックネームを入力してください</p>
			<?php endif; ?>
		</dd>
		<dt>メールアドレス<span class="required">必須</span></dt>
		<dd>
			<input type="text" name="email" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['email'])); ?>" />
			<?php if ($error['email'] === 'blank'): ?>
				<p class="error">* メールアドレスを入力してください</p>
			<?php endif; ?>
			<?php if ($error['email'] === 'duplicate'): ?>
				<p class="error">* 指定されたメールアドレスはすでに登録されています</p>
			<?php endif; ?>
		<dt>パスワード<span class="required">必須</span></dt>
		<dd>
			<input type="password" name="password" size="10" maxlength="20" value="<?php print(htmlspecialchars($_POST['password'])); ?>" />
			<?php if ($error['password'] === 'length'): ?>
				<p class="error">* パスワードは4文字以上で入力してください</p>
			<?php endif; ?>
			<?php if ($error['password'] === 'blank'): ?>
				<p class="error">* パスワードを入力してください</p>
			<?php endif; ?>
        </dd>
		<dt>写真など</dt>
		<dd>
		<!-- これだけでファイルピッカーを表示するためのファイル選択ボタンが表示される -->
        	<input type="file" name="image" size="35" value="test"  />
			<?php if ($error['image'] === 'type'): ?>
				<p class="error">* 拡張子が「.jpg」、「.png」、「.gif」のファイルを選択してください</p>
			<?php endif; ?>
			<?php if (!empty($error)): ?>
				<p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
			<?php endif; ?>
        </dd>
	</dl>
	<div><input type="submit" value="入力内容を確認する" /></div>
</form>
<br>
<p><a href = "../login.php">戻る</a></p>

</div>
</body>
</html>
