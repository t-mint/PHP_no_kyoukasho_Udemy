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
// サンプル03のオブジェクト思考な書き方
// DateTimeオブジェクトをインスタンス化して$todayに代入
$today = new DateTime();
// インスタンス化したDateTimeをformat関数で表示形式を指定して出力してる
print($today->format('G時i分s秒'));
?>
</pre>
</main>
</body>    
</html>