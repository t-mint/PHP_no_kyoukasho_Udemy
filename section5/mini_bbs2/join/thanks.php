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
<?php
// 登録変更ページ（change_update.php）から飛んできた場合はこちらを表示（パラメータで判定）
if($_REQUEST['kind'] == 'update'){
?>
    <p>ユーザー情報の変更が完了しました</p>
    <p><a href="../">掲示板へ戻る</a></p>
<?php
}
?>

<?php
// 新規登録ページ（check.php）から飛んできた場合はこちらを表示（パラメータで判定）
if($_REQUEST['kind'] == 'insert'){
?>
    <p>ユーザー情報の登録が完了しました</p>
    <p><a href="../">ログインする</a></p>
<?php
}
?>

</div>
</body>
</html>
