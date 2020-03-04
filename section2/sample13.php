<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>22. file_put_contents - ファイルに内容を書き込む</title>
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
// file_put_contents(書き込むファイルの場所（このファイルからの相対パス）, 書き込む内容)
// ：ファイルに書き込む関数。戻り値でTrue（成功）かFalse（失敗）を返す
$success = file_put_contents('../../news_data/news.txt', '2018-06-01 ホームページをリニューアルしました');
if($success) {
    print('ファイルへの書き込みが完了');
} else {
    print('書き込みに失敗。フォルダの権限などを確認してください。');
}
?>

</pre>
</main>
</body>    
</html>