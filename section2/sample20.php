<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>31. 半角数字に直して、数字であるかをチェックする</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
    <?php
    // $age = 20;
    // $age = 'あいうえお';
    $age = '２０';

    // mb_convert_kana：全角数字を半角数字に変換する
    $age = mb_convert_kana($age, 'n', 'UTF-8');
    // is_numeric：数字かどうか判定してくれる
    if(is_numeric($age)){
        print($age . '歳');
    }else{
        print('※年齢が数字じゃないよ！');
    }
    ?>
</pre>
</main>
</body>    
</html>