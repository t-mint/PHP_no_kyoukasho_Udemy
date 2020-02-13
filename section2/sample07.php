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
<h2>16. 1年後までのカレンダーを表示する①</h2>
<h2>17. 1年後までのカレンダーを表示する②</h2>
<pre>
<!-- ここにプログラムを記述します -->
<?php
// タイムスタンプ
// （1970年1月1日を0として、現在までの秒数をカウントした値）
print(time());
print("\n");

// 明日の日付　＝　現在のタイムスタンプ＋60秒×60分×24時間
print(time() + 60 * 60 * 24);
print("\n");

// date関数で表示形式を指定して、明日の日付を表示
print(date('n/j(D)', time() + 60 * 60 * 24));
print("\n");

// 日付をタイムスタンプに変換する
print(strtotime('1999/7/31'));
print("\n");

// date関数に組み込んで、2日後のタイムスタンプから日付を表示
print(date('n/j(D)', strtotime('+2day')));

// 365日後までの日付を表示
for($i=1; $i<=365; $i++) {
    print(date('n/j(D)', strtotime('+'.$i.'day')));
    print("\n");　
}
// for文書き方その２　{}と意味は同じ
// for():
    // 内容
// endfor;

?>
</pre>
</main>
</body>    
</html>