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
<h2>14. while構文 - 1から365までの数字を表示する①</h2>
<h2>15. for構文と比較演算子 - 1から365までの数字を表示する②</h2>
<pre>
<!-- ここにプログラムを記述します -->
<?php

// while
// $i = 1;
// while ($i <= 365) {
//     print("お皿が".$i."枚\n");
//     $i++;
// }

// for
for ($i = 1; $i <= 365; $i++) {
    print("お皿が".$i."枚\n");
}

print("\n・・・お皿が足りなーい！（裏飯屋）")

?>
</pre>
</main>
</body>    
</html>