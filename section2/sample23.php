<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>34. 剰余算 - 一行ごとにテーブルセルの色を変える</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>    
</header>

<main>
<h2>Practice</h2>
<pre>
    <?php
    // // 曜日のカレンダー表示
    // // 例えば31日分の曜日を繰り返し表示するのを剰余算を使って行う
    // $week = array('金','土','日','月','火','水','木');
    // for($i=1; $i < 31; $i++) {
    //     print("\n" . $week[$i%7] . "：$i % 7 = " . $i%7);
    // }
    ?>
</pre>
<table>
    <?php
    // 一行ごとにテーブルセルの色を変える
    for($i=1; $i <= 10; $i++) {
        if($i % 2){
            print('<tr style="background-color:#ccc">');
        } else {
            print('<tr>');
        }
        print("<td>". $i . "行目</td>");
        print("</tr>");
    }
    ?>

</table>
</main>
</body>    
</html>