<?php
// DB接続を他ページで使う用　「require('dbconnect.php')」で読み込ませて使う
try {
    $db = new PDO('mysql:dbname=mini_bbs2;host=127.0.0.1;charset=utf8', 'root', '');
} catch(PDOException $e) {
    print('DB接続エラー：'. $e->getMessage());
}