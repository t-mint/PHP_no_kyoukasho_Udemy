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
<h2>63. メモを変更する、編集画面</h2>
<pre>
    <?php

    require('dbconnect.php');

    // ＜DB変更＞
        // 前のページ（update.php）からPOSTで受け取ったパラメータを使って、対象IDのmemoカラムの内容を更新する
        // SQLアップデート文
        $statement = $db->prepare('UPDATE memos SET memo=?  WHERE id=?');
        // プレースフォルダの値を指定して実行
        $statement->execute(array($_POST['memo'], $_POST['id']));
        
    ?>
    メモの内容を変更しました
</pre>
<p><a href="index.php">戻る</a></p>
</main>
</body>    
</html>