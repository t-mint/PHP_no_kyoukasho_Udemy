<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>19. if構文 - 9時よりも前の時間の場合に、警告を表示する</title>
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
// 'G'は現在の時間を取得するパラメータ
print(date('G'));
print "\n";

if(date('G') < 9) {
    print('※ 現在受付時間外です');
} else {
    print('ようこそ');
}
print "\n";

$x = 'あいうえお';
// 空文字（'' ）判定している
if($x !== '') {
    print('xには文字が入っています');
}
print "\n";

// 上の空文字判定と同じ結果になる。
// なぜなら変数に何かが入っていればTrue、入っていなければFalseが返るから
if($x) {
    print('xには文字が入っています');
}
print "\n";


?>
</pre>
</main>
</body>    
</html>