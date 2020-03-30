<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>32. 郵便番号を正規表現を使ってチェックする</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
    <?php
    // $zip = '987-6543';
    $zip = '３２５-１０００';

    // 英数字を半角に直す、「-」が入ってくるので'n'ではなく'a'を使う
    $zip = mb_convert_kana($zip, 'a', 'UTF-8');
    // preg_match：指定の正規表現になっているかチェックしてくれる
    // 今は郵便番号ぐらいの簡単なバリチェックならHTML5の機能でできちゃうので実用的じゃないけど...
    // 下記指定の正規表現を解説
    // 　\A：次に続く正規表現の指定が先頭であること
    // 　d{3}：dはデシマル（数字）のことで、数字が3回続いていること
    // 　[-]：前後を「-」で繋げていること
    // 　d{4}：数字が4回続いていること
    // 　\z：前に記載した正規表現の指定で終わっている（最後である）こと
    if (preg_match("/\A\d{3}[-]\d{4}\z/", $zip)) {
        print('郵便番号：〒' . $zip);
    } else {
        print('※郵便番号の形式になってないよ！半角英数字で「123-4567」のように入れてね！');
    }
    ?>

</pre>
</main>
</body>    
</html>