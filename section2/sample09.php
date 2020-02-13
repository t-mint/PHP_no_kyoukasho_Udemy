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
<h2>27. 連想配列とforeach構文 - 英単語と日本語の対応表を作る</h2>
<pre>
<!-- ここにプログラムを記述します -->
<?php
// 連想配列でわかりやすいキー(矢印の前の部分)を指定する
$fruits = [
    'apple'=>'りんご', 
    'grape'=>'ぶどう', 
    'lemon'=>'レモン',
    'tomato'=>'トマト',
    'peach'=>'もも'
];
// 連想配列の取り出しはキーを指定すればいい
print($fruits['grape']);
print "\n";

// foreach：配列専用のループで、連想配列の値を取り出す
foreach($fruits as $val) {
    print($val."\n");
}

// 値だけじゃなくて、キーの文字もループ内で表示したい場合
foreach($fruits as $english => $japanese) {
    print($english. '：'. $japanese. "\n");
}

?>
</pre>
</main>
</body>    
</html>