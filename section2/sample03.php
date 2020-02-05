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
<h2>Practice</h2>
<pre>
<!-- ここにプログラムを記述します -->
<?php
// タイムゾーンの設定：
// アパッチの設定からタイムゾーンが弄れない（レンタル鯖とか）場合はこれで設定できる
date_default_timezone_set('Asia/Tokyo');
// 時分秒などの表示（「.」は文字列連結してる）
print('スジャータIFCコーヒーが' . date('G時i分s秒') . 'をお伝えします');
?>
</pre>
</main>
</body>    
</html>