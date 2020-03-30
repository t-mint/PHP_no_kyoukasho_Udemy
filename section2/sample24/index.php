<?php
// 普通の変数がページの移動で保持されないことを確認するための変数
$value = '変数に保存した値';

// setcookie：HTMLタグより前に書く
// 引数１：変数名
// 引数２：保存したい値
// 引数３：クッキーの保持期限（この例の場合は、今日の時刻（time()）　＋　1日（60 * 60 * 24）　×　14　＝　14日間）
setcookie('save_message', 'cookieに保存した値', time() + 60 * 60 * 24 *14);
?>
<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../css/style.css">

<title>35. Cookieに値を保存する</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
    <!-- クッキーの保持を確認するためにページ遷移のリンク -->
    <a href="page02.php">page02</a>
</pre>
</main>
</body>    
</html>