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
<h2>51. プロジェクトを準備する</h2>
<h2>52. PDO - MySQLに接続する</h2>
<h2>53. exec - SQLを実行する</h2>
<h2>54. query - SELECT SQLを実行する</h2>
<pre>
<?php

// ＜52. PDO - MySQLに接続する＞
try{
    // PDO：PHP Data Object・・・PHPでDBを扱うオブジェクトの名前
    // 以下でDB、文字コード、DBのIDとパスをセットしている
    // ・dbname=xxx：xxxはsection3の時にPhpMyAdminで作成したDBの名前
    // ・host=：自身を指すIPアドレス「127.0.0.1」を指定（DBの場所が自身のPCの中にあるため）
    // ・'root',''：DBのユーザー名とパスワード。XAMPPの場合はこれで良い
    $db = new PDO('mysql:dbname=mydb2;host=127.0.0.1;charset=utf8', 'root', '');

// try{}の中でDB接続の例外エラー（PDOException）が発生したときにキャッチして、エラーメッセージを表示させてる
} catch(PDOException $e) {
    echo 'DB接続エラー：'.$e->getMessage();
}

// ＜53. exec - SQLを実行する＞
// // exec：エグゼックと読む。SQL文を発行（変更・挿入・削除）するメソッド
// // execの戻り値：影響（変更や削除）を与えた行の数
// //              なので、ここでの$countには挿入した行数「1」が戻る（$dbは上でDB接続情報を格納済み変数）
// // 　　　        ※ メソッドでSQL文を発行する時は文全体を「'」シングルクォートで括るため、中で使うSQL文にクォートが必要な場合は被らないように「"」にして分ける
// $count = $db->exec('INSERT INTO my_items SET maker_id=1, item_name="もも", item_name_kana="モモ", price=210, keyword="缶詰,ピンク,甘い"');
// echo $count . '件のデータを挿入しました';

// ＜54. query - SELECT SQLを実行する＞
// query：SQLクエリの中身を取り出す（SELECTなどの参照系）メソッド。
// queryの戻り値：SELECT文で得られた値が戻る
//               なので、ここでの$recordsにはmy_itemsテーブルの中身が戻る
$records = $db->query('SELECT * FROM my_items');

// fetch：DBから受け取った行から1行を連想配列で取り出し、取り出せなければfalseを返すので、whileで回して全行取り出している
while ($record = $records->fetch()) {

    // fetchで取り出した連想配列からカラムitem_nameの値を取り出して出力している
    print($record['item_name'] . "　｜　" . $record['price'] . "円" . "\n");
}
?>

<!-- 【自習】DBから値を取り出したあとに、HTMLのテーブルタグで成形して出力するようにしてみた -->
<?php $records = $db->query('SELECT * FROM my_items'); ?>
<table>
    <tr>
        <th>商品名　　　</th>
        <th>価格　　　</th>
        <th>在庫　　　</th>
    </tr>
<?php while ($record = $records->fetch()) { ?>
    <tr>
        <td> <?php print($record['item_name']); ?></td>
        <td> <?php print($record['price']); ?>円</td>
        <td> <?php print($record['sales']); ?>個</td>
    </tr>
<?php } ?>
</table>

</pre>
</main>
</body>    
</html>