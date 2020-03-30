<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>25. JSONを読み込む</title>
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
// sample15でやったxmlを取得して表示と同様に、JSONを取得して表示ver

// ファイルの内容を読み込む（この段階ではまだコードをテキストとして読み込んでいるに過ぎない）
// $file = file_get_contents('https://h2o-space.com/feed/json/');

// オフライン練習用にローカル保存したxmlを参照する場合
$file = file_get_contents('./sample16.json');

// データをjson形式で返す
$json = json_decode($file);

// 取得したjsonをRSS情報として表示
// $jsonの中の「items:」タグにアクセスして、foreachでitemsの[]の中にある要素（ここではtitleとurl）を配列で取得して、
// HTMLのaタグでリンクをつけて表示している
foreach ($json->items as $item):
?>
・タイトル：<a href="<?php print($item->url); ?>"><?php print($item->title); ?></a>
　　　内容：<?php print($item->summary); ?><br>
<?php endforeach ?>

</pre>
</main>
</body>    
</html>