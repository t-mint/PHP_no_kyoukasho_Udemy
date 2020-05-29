<?php require('dbconnect.php'); ?>
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

<?php
// バリデーションチェック（index.phpと一緒なので解説省略）
if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {

    // 前のページから送られてきたパラメータからIDを受け取る
    $id = $_REQUEST['id'];

    // 受け取ったIDのレコードをSELECTして、結果をフェッチで取り出す
    $memos = $db->prepare('SELECT * FROM memos WHERE id=?');
    $memos->execute(array($id));
    $memo = $memos->fetch();
}
?>

<form action="update_do.php".php" method="post">
    <!-- 編集登録ページ（update_do.php）に対象のIDを渡すために、hiddenでパラメータをセット -->
    <input type="hidden" name="id" value="<?php print($id); ?>">
    <textarea name="memo" cols="50" rows="10"><?php print($memo['memo']); ?></textarea><br>
    <button type="submit">登録する</button>
</form>

<p><a href="index.php">戻る</a></p>
</main>
</body>    
</html>