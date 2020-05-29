<?php
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

	// emptyメソッド：配列が空っぽであればTRUEを返す
	if (empty($error)){
		// 指定のページへジャンプする
		header('Location: check.php');
		exit();
	}
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
        	<input type="file" name="image" size="35" value="test"  />
        </dd>
	</dl>
	<div><input type="submit" value="入力内容を確認する" /></div>
</form>
</div>
</body>
</html>
