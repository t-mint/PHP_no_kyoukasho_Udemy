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
<h2>64. いらないデータを削除する、削除機能</h2>
<pre>
    <?php

    require('dbconnect.php');

    // ＜DB削除＞
    // バリデーションチェック（index.phpと一緒なので解説省略）
    if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])){
        // 前のページから送られたレコードIDのパラメータを受け取って変数に代入
        $id = $_REQUEST['id'];

        // 前のページ（update.php）からPOSTで受け取ったパラメータを使って、対象IDのmemoカラムの内容を更新する
        $statement = $db->prepare('DELETE FROM memos WHERE id=?');
        $statement->execute(array($id));
    }
    ?>
    メモを削除しました
</pre>
<p><a href="index.php">戻る</a></p>
</main>
</body>    
</html>