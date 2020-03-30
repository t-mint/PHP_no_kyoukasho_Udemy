<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../css/style.css">

<title>30. 複数選択可能なチェックボックス、リストボックスの値を取得する</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
    <?php
    // $_POST['reserve']は、配列化したcheckboxのname属性を受け取るために、受け取り側も配列化している
    // foreachで受け取った配列を順番に出力している
    foreach ($_POST['reserve'] as $reserve) {
        print(htmlspecialchars($reserve, ENT_QUOTES) . ' ');
    }
    ?>
</pre>
</main>
</body>    
</html>