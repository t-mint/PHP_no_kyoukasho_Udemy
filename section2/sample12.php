<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>21. spirntf - 書式を整える</title>
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
// sprintf：表示形式を指定して表示
// 例えば「%04d」
// %：値の表示形式のパラメータ
// 0：表示桁数に足りない桁部分は0で埋める
// 4：表示桁数は4桁
// d：値は数字（値が数字以外であれば無視）※値が文字であるなら「s」とする
// 表示形式以降の引数は、表示形式に対応する値で、表示形式の数（「%」の数）だけ用意する
$date = sprintf('%04d年 %02d月 %02d日', 2018, 1, 23);
print($date);
?>
</pre>
</main>
</body>    
</html>