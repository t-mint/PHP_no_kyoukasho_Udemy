<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../css/style.css">

<title>26. フォームに入力した内容を取得する①</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
    <!-- $_REQUEST[]：[]の中には画面遷移元（ここではsample17/index.html）のform内のinputタグのname属性を指定すると、
    指定したformの値を受け取ることができる
    formのmethod属性がGETかPOSTかわからない時は$_REQUESTでどちらでも受け取れるが、わかっているなら合わせて$_GETまたは$_POSTにする-->
    <!-- htmlspecialchars(), ENT_QUOTES：()内のデータをエスケープ処理（受け取ったデータにhtmlタグが入ってても文字列として扱う） -->

    お名前：<?php print(htmlspecialchars($_REQUEST['my_name'], ENT_QUOTES)); ?>
 
</pre>
</main>
</body>    
</html>