<?php
// 59. 接続プログラムを共通プログラムにする

// DB接続するための記述だが、他のページでDB接続するときにこのファイルを「require('dbconnect.php')」で読み込ませて使う
try{
    $db = new PDO('mysql:dbname=mydb2;host=127.0.0.1;charset=utf8', 'root', '');

} catch(PDOException $e) {
    echo 'DB接続エラー：'.$e->getMessage();

}
?>