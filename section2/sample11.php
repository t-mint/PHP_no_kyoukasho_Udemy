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
<h1 class="font-weight-normal">20. ceil, floor, round - 小数を整数に切り上げる・切り下げる</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
<!-- ここにプログラムを記述します -->
3,000円のものから、100円値引きした場合は
<?php
// floor：少数を切り捨てる関数
print(floor(100 / 3000 * 100));
?>%引きです。

■そのほかの計算
切り上げ（ceil）⇒　<?php print(ceil(100 / 3000 * 100)); ?>
<!-- 第2引数は少数第何位で四捨五入するかの指定 -->
四捨五入（round）⇒　<?php print(round(100 / 3000 * 100, 1)); ?>
</pre>
</main>
</body>    
</html>