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
<h2>55. フォームからの情報を保存する①</h2>
<h2>56. フォームからの情報を保存する②</h2>
<pre>
    <?php

    require('dbconnect.php');

    // ＜DB登録＞
        // // 方法１（非推奨＆SQL文が見にくい）
        // // $_POST[memo]：遷移前のページからPOSTで渡ってきたname属性がmemoの値を、カラム名memoの値にセット
        // // created_at=NOW()：カラム名created_atに現在の日時（SQL構文内で使えるメソッド）をセット
        // $db->exec('INSERT INTO memos SET memo="' . $_POST['memo'] . '", memo2="方法１", created_at=NOW()');

        // // 方法２
        // // 上のやり方はDB登録方法はPOSTの値を直接SQLに組み込んでいるので危険なので、
        // // prepareメソッドを使ってPOSTの値をプレースフォルダにするやり方に直す。
        // // prepareメソッド：事前準備。POSTなどは直接書かずに「?」にしておく。
        // // executeメソッド：引数はprepareで「?」にした部分が「何か」を実際に指定している。
        // $statement = $db->prepare('INSERT INTO memos SET memo=?, memo2="方法２", created_at=NOW()');
        // $statement->execute(array($_POST['memo']));

        // 方法３
        // bindParamメソッド：複数のプレースフォルダを入れる時にはこっち。
        // bindParamの引数は変数のみしか指定できない（直接文字列を引数にできない）
        $statement = $db->prepare('INSERT INTO memos SET memo=?, memo2=?, created_at=NOW()');
        $statement->bindParam(1, $_POST['memo']);
        $memo2 = "方法３";
        $statement->bindParam(2, $memo2);
        $statement->execute();

        echo 'メッセージが登録されました';

    ?>
</pre>
</main>
</body>    
</html>