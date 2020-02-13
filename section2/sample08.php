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
<h2>18. 配列 - 曜日を日本語で表示する</h2>
<pre>
<!-- ここにプログラムを記述します -->
<?php
// 'w'は曜日を数字で表すパラメータ(日曜日を0 ～ 土曜を6で表示する)
print(date('w'));
print "\n";

// 配列に曜日を入れる（曜日の数字と配列の添え字が一致するように合せている）
// 古い書き方だとarray('','',....'');で、[]（ブラケット）を使った書き方は新し目の書き方
$week_name = ['日', '月', '火', '水', '木', '金', '土', ];
// 配列の取り出し
print($week_name[0]);
print "\n";

// 添え字と合せていることで、今日の曜日の表示が簡単にできるようになる
print($week_name[date('w')]);

?>
</pre>
</main>
</body>    
</html>