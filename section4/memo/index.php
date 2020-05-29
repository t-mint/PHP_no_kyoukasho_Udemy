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
<h2>57. データの一覧・詳細画面を作る①</h2>
<h2>58. データの一覧・詳細画面を作る②</h2>
<h2>59. 接続プログラムを共通プログラムにする</h2>
<h2>60. 件数の多いレコードを、ページを分ける「ページング（ページネーション）」①</h2>
<h2>61. 件数の多いレコードを、ページを分ける「ページング（ページネーション）」②</h2>
<h2>62. 件数の多いレコードを、ページを分ける「ページング（ページネーション）」③</h2>

<p><a href="_index.php">51～54（DB接続してmy_itemsテーブルから指定のカラムを取り出して表示）はこちら</a></p>
<br>
<h2>メモ一覧</h2>
<br>
<p><a href="input.html">メモを新規登録する</a></p>

<?php

// require：他のファイルを取り込むことができるファンクション
// DB接続PDOの記述を別ファイルにしてこのファンクションで読み込んでいる
// このような他ページでも多用する汎用的な記述はrequireで取り込むとスッキリする
require('dbconnect.php');

// ページの存在チェック
// isset（存在チェック）で、パラメータにページが指定されているか、
// 同時にis_numericで、パラメータが数字であるかもチェック
if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    // $_REQUEST['page']が存在して数字なら、その値を受け取る
    $page = $_REQUEST['page'];
} else {
    // $_REQUEST['page']が存在しないか数字ではないなら、1ページ目とする
    $page = 1;
}
// 取得したページ数のパラメータ値から、表示させたいLIMITの開始位置になるように計算
// 5件ずつ表示したいので、page=1はLIMIT 0、page=2はLIMIT 5、page=3はLIMIT 10　となるような式になってる
$start = 5 * ($page -1);

// memosテーブルからレコードをSELECTする時に、LIMIT句で1ページ表示件数を上位5件に絞っている。
// 次のページへ遷移した時に次の5件を表示するために、LIMITの開始をプレースフォルダにしている
// わかりにくいけど例えば「LIMIT 5」なら、5の次から5件を表示なので、6～10件が表示される
$memos = $db->prepare('SELECT * FROM memos ORDER BY id DESC LIMIT ?, 5');
$memos->bindParam(1, $start, PDO::PARAM_INT);
$memos->execute();
?>

<!-- <article>：一覧表示するタグ -->
<article>
    <?php while ($memo = $memos->fetch()): ?>
        <!-- mb_substr：文字数を制限するファンクション。引数１が開始位置、引数２が文字数。これで文字数が多い場合は一部だけを表示するようになる -->
        <!-- hrefのリンク先には対象レコードのIDをパラメータ（memo.php?id=xxx）で付加している
            リンク先のmemo.phpではこのIDのパラメータを$_REQUESTで受け取って、その内容を個別に表示するようなページにしてある -->
        <p><a href="memo.php?id=<?php print($memo['id']); ?> "><?php print(mb_substr($memo['memo'], 0, 50)); ?> </a> </p>
        <time> <?php print($memo['created_at']); ?> </time>
        <hr>
    <?php endwhile ?>
    

    <!-- ページネーション（前のページと次のページへのリンク） -->
    
    <!-- 最終ページ判定のために最大ページ数を算出 -->
    <!-- （最大ページの判定部分は動画見ないで自分で考えて仕上げたけど、動画とあっててよかった） -->
    <?php 
    // DBからCOUNT(*)でレコード件数を取得（ASでカラム名付けないと取り出したあと指定できなくて困った）
    $record = $db->query('SELECT COUNT(*) AS cnt  FROM memos');
    // レコードの取り出し（結果のレコードは1行だけのはずだが、fetchしないと値を取り出せなかった）
    $count = $record->fetch();
    // レコード件数を表示ページ数５で割って、小数が出たらceilで切り上げることで最大ページ数を算出した
    $maxPage = ceil($count['cnt'] / 5);
    ?>

    <!-- 現在のページが1ページ目であれば、「前のページへ戻る」リンクを表示しないための判定 -->
    <?php if ($page >= 2) { ?>
        <!-- 前のページへ戻るリンクの表示 -->
        <a href='index.php?page=<?php print($page-1); ?> '><?php print($page-1); ?>ページ目へ</a>
    <?php } ?>
    |
    <!-- 現在のページが最終ページ目であれば、「次のページへ進む」リンクを表示しないための判定 -->
    <?php if($page < $maxPage) { ?>
        <!-- 次のページへ進むリンクの表示 -->
        <a href='index.php?page=<?php print($page+1); ?> '><?php print($page+1); ?>ページ目へ</a>
    <?php } ?>

</article>
</main>
</body>    
</html>