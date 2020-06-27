<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
    // パラメータで送られて来た削除対象の投稿IDを変数に代入
    $id = $_REQUEST['id'];

    // 削除対象の情報をDBから取得
    $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
    $messages->execute(array($id));
    $message = $messages->fetch();

    // ログイン中のユーザIDと削除対象のIDが等しければ
    if ($_SESSION['id'] == $message['member_id']) {
        // 対象IDを削除
        $del = $db->prepare('DELETE FROM posts WHERE id=?');
        $del->execute(array($message['id']));
    }
}

header('Location: index.php');
exit();

?>