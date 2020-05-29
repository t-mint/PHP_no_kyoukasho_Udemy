<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>PHP</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>57. データの一覧・詳細画面を作る①</h2>
<h2>58. データの一覧・詳細画面を作る②</h2>
<?php

require('dbconnect.php');

// 前のページから送られたレコードIDのパラメータを受け取って変数に代入
$id = $_REQUEST['id'];

// バリデーションチェック
// is_numericで数字かどうかのチェックを行い、同時に0以下の数字ないかもチェックしている
// エラーに該当した場合はエラーメッセ表示後にexit()で終了している
if (!is_numeric($id) || $id < 0) {
    print('1以上の数字で指定してください');
    exit();
}
// パラメータ（$id = $_REQUEST['id]）から受け取ったIDのレコード1行を取得して表示する
$memos = $db->prepare('SELECT * FROM memos WHERE id=?');
$memos->execute(array($id));
$memo = $memos->fetch();
?>
<article>
    <pre><?php print($memo['memo']); ?></pre>

    <a href="update.php?id=<?php print($id); ?>">編集する</a>
    |
    <a href="delete.php?id=<?php print($id); ?>">削除する</a>
    |
    <a href="index.php">戻る</a>
</article>

</main>
</body>    
</html>