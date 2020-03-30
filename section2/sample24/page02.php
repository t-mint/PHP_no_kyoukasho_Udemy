<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../css/style.css">

<title>35. Cookieに値を保存する</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
    <!-- 表示したときエラーになるのは、ただの変数の値はページを移動した時に消えているから -->
    変数の値：<?php print($value); ?>
    <!-- Cookieの値は保存されているので、ページの移動でも表示される -->
    <!-- $_COOKIE[]：保存したクッキーを取り出すグローバル変数 -->
    <!-- クッキーはブラウザを閉じても設定した保存期間は保持される -->
    Cookieの値：<?php print($_COOKIE['save_message']); ?>
</pre>
</main>
</body>    
</html>