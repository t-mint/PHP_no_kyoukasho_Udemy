<?php
// このメソッドを宣言しないとセッションが使えない
session_start();
?>
<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../css/style.css">

<title>36. セッションに値を保存する</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
    <!-- $_SESSION[]：保存したセッションを取り出すグローバル変数 -->
    <!-- クッキーと違ってセッションはブラウザを閉じると消える -->
    <?php print($_SESSION['session_message']); ?>
</pre>
</main>
</body>    
</html>