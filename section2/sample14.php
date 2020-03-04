<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>23. file_get_contents - ファイルの読み込み</title>
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
// file_get_contents(読み込むファイルの場所（このファイルからの相対パス）)
// ：ファイルを読み込む関数。戻り値で内容を返す
$news = file_get_contents('../../news_data/news.txt');
// 取得した内容を追記(一番下に追加)
$news .= "2019-02-14 ホームページを閉鎖いたします\n";
// 取得した内容を追記(一番上に追加)
$news = "2018-04-01 ホームページを開設いたしました\n". $news;

// ファイルに書き込む関数を使って、追記した内容をファイルに上書き
file_put_contents('../../news_data/news.txt', $news);

print($news);
print "\n\n";

// readfile：ファイルを読み込む
// file_get_contentsと比べて、こっちの方が戻り値もいらないため簡単だが、単純に表示することしかできない。
// （例えば、内容の再加工とか、受け取った内容を使ってプログラムの動作変更ができない）
readfile('../../news_data/news2.txt');
?>
</pre>
</main>
</body>    
</html>