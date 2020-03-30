<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>24. simplexml_load_file - XMLの情報を読み込む</title>
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
// simplexml_load_file：xmlをロードするシンプルな関数。戻り値でxmlの内容を取得する。
// $xmlTree = simplexml_load_file('https://h2o-space.com/feed/');
// オフライン練習用にローカル保存したxmlを参照する場合
$xmlTree = simplexml_load_file('./sample15.xml');

// 取得したxmlの中身を確認
var_dump($xmlTree);

// 取得したxml（HTML同様にタグの親子要素で構成）をRSS情報として表示
// $xmlTreeの中の<channel>タグの中の<item>要素にアクセスして、foreachで複数あるitem要素を配列で取得して、HTMLのaタグでリンクをつけて表示している
foreach ($xmlTree->channel->item as $item):
?>
・タイトル：<a href="<?php print($item->link); ?>"><?php print($item->title); ?></a>
　　　内容：<?php print($item->description); ?><br>
<?php
    endforeach;
?>
</pre>
</main>
</body>    
</html>