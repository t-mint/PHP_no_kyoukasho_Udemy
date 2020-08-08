<?php
session_start();
require('dbconnect.php');
// 【ログイン判定】ーーーーーーーーーーーーーーーーーーーーーーーー
// ログインの時に記録したセッションIDが存在していてかつ、ログインしてから1時間以内であれば
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  // 接続開始時間を今の時間に更新
  $_SESSION['time'] = time();

  // ログイン中（membersテーブルのIDがセッションIDと同一）のユーザ情報を取得
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();

}else {
  // ログインしてなければログインページに遷移させる
  header('Location: login.php');
  eixt();
}
// ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

// 【メッセージ投稿処理】ーーーーーーーーーーーーーーーーーーーーーーーー
// （投稿するボタンを押したらPOSTから投稿内容をDBに登録する）
// 投稿ボタンが押されたら（＝POSTが空でなければ）
if(!empty($_POST)) {
  // メッセージボックスの内容が空でなければ
  if($_POST['message'] !== '') {
    // postsテーブルに会員IDと投稿内容、返信先の投稿ID（返信でなければ0が入る）を登録する
    $message = $db->prepare('INSERT INTO posts SET member_id=?, message=?, reply_message_id=?, created=NOW()');
    // $_POST['reply_post_id']はテキストエリアのhiddenでセットしている$_REQUEST['res']の値
    $message->execute(array($member['id'], $_POST['message'], $_POST['reply_post_id']));
  }

  // 投稿後に自身のページ（index.php）に再度アクセス
  // これしないとPOSTに値が入ったまま画面が維持されるのでリロードする度にDBに重複登録されてしまう
  header('Location: index.php');
  eixt();
}
// ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

// 【ページネイション処理】ーーーーーーーーーーーーーーーーーーーーーーーー
// ページネイション用にURLパラメータから送られてきたページ番号を変数へ代入
$page = $_REQUEST['page'];

// ページ番号が空欄であれば、1ページ目に置き換える
if ($page == ''){
  $page =1;
}
// max関数を使ってページ番号が1未満であれば、1ページ目に置き換える
$page = max($page, 1);

// 最大ページ数の取得
// DBから全投稿数を取得
$count = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $count->fetch();

// 全投稿数を最大ページ数に変換する計算式
// ceil()は小数切り上げる関数（0.1でも１に切り上げる）で、これで最終ページが5件未満でも1ページ扱いで計算できる
$maxPage = ceil($cnt['cnt'] / 5);

// min関数を使ってページ番号が最大ページを超えていれば、最大ページに置き換える
$page = min($page, $maxPage);

// 投稿取得始数位置の計算式（ページ番号を適切な投稿開始位置に変換する式）
// （ページ番号1が投稿開始0、ページ番号2が投稿開始5、ページ番号3が投稿開始10とうまく変換される）
$start = ($page - 1) * 5;
// ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

// 【投稿内容一覧を取得】ーーーーーーーーーーーーーーーーーーーーーーーー
// WHERE条件はコメントを投稿してない会員情報を除外するために両方のテーブルにいるIDとしている
$posts = $db->prepare('SELECT m.name, m.picture, p.* 
                    FROM members m, posts p 
                    WHERE m.id=p.member_id 
                    ORDER BY p.created DESC LIMIT ?,5');
// $posts->execute(array($start))でやってしまうと文字列で渡ってしまうので、
// ここではbindParamを使って型を数字に指定している
$posts->bindParam(1, $start, PDO::PARAM_INT);
$posts->execute();
// ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

// 【返信の処理】ーーーーーーーーーーーーーーーーーーーーーーーー
// [Re]リンクが押されているか（URLパラメータに「?res=」が付加されているか）
// ここでは$_REQUESTで受け取っているが$_GETでもよさそう
if (isset($_REQUEST['res'])) {
  // DBから返信対象の投稿者情報と投稿内容を取得するSQL文（返信対象の識別は条件の「p.id=?」で判別してる）
  $response = $db->prepare('SELECT m.name, m.picture, p.* 
                          FROM members m, posts p 
                          WHERE m.id=p.member_id AND p.id=?');
  // プレースホルダーにURLパラメータから送られた投稿IDをセットしてSQL実行
  $response->execute(array($_REQUEST['res']));
  // 取り出し
  $table = $response->fetch();
  // SQLから取得した返信用メッセージを成形（返信時にテキストエリアに投稿元情報を引用して表示する用のメッセージ）
  $message = '@'. $table['name']. '　'. $table['message'];
}
// ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

// 2018/8/7改修：開始
//ファンクション：htmlspecialchars関数を使ったエスケープ処理をファンクション化
function h($value){
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

//ファンクション：本文内のURLを検知してリンク化
function makeLink($value){
  return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)", '<a href="\1\2">\1\2</a>', $value);
}
// 2018/8/7改修：終了

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ひとこと掲示板</title>

	<link rel="stylesheet" href="style.css" />
</head>

<body>
<div id="wrap">
  <div id="head">
    <h1>ひとこと掲示板</h1>
  </div>
  <div id="content">
<!-- 2018/8/7改修：開始 -->
  <!-- ログイン中表示、および登録内容変更ページへのリンク -->
  <div style="text-align: right"><a href="change_input.php">
  <?php echo h($member['name']); ?>さんログイン中
  </a></div>
<!-- 2018/8/7改修：終了 -->

  	<div style="text-align: right"><a href="logout.php">ログアウト</a></div>
    <form action="" method="post">
      <dl>
        <dt><?php htmlspecialchars(print($member['name']), ENT_QUOTES); ?>さん、メッセージをどうぞ</dt>
        <dd>
        <!-- 返信用メッセージが（$message）があればテキストエリアに表示する -->
          <textarea name="message" cols="50" rows="5"><?php print(htmlspecialchars($message, ENT_QUOTES));?></textarea>
          <!-- hiddenパラメータで返信先の投稿IDがあれば渡す -->
          <input type="hidden" name="reply_post_id" value="<?php htmlspecialchars(print($_REQUEST['res']), ENT_QUOTES); ?>" />
        </dd>
      </dl>
      <div>
        <p>
          <input type="submit" value="投稿する" />
        </p>
      </div>
<!-- 2018/8/7改修：開始　★機能しないため次回調査改修予定-->
      <?php
      //入力フォームが空欄メッセ表示
      if(isset($_POST['message']) && $_POST['message'] == ''):
      ?>
          <p style="color: #F33;">※投稿メッセージを入力してください</p>
      <?php endif; ?>
<!-- 2018/8/7改修：終了 -->
    </form>
<?php foreach($posts as $post): ?>
    <div class="msg">
    <!-- ユーザ画像の表示（imgタグのalt属性は画像が表示できなかった時の表示なので、一応ユーザ名など入れておくとよい -->
    <img src="member_picture/<?php print(htmlspecialchars($post['picture'], ENT_QUOTES)); ?>" width="48" height="48" alt="<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>" />
    <!-- 投稿内容とユーザ名の表示 -->
    <!-- [<a href="index.php?res= ～ $post['id'] ～ >Re</a>]：
          [Re]リンクが押された時にパラメータに投稿IDを付加して、どのコメントへの返信なのかを識別させている -->
    <p><?php print(htmlspecialchars($post['message'], ENT_QUOTES)); ?><span class="name">（<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>）</span>[<a href="index.php?res=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>">Re</a>]</p>

    <!-- 投稿時間の表示（リンク先は対象のメッセージ詳細表示ページ -->
    <p class="day">
    <a href="view.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>"><?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?></a>

    <!-- 返信元のメッセージへのリンク -->
    <!-- if文で返信メッセージのみリンクテキストを表示している -->
    <?php if ($post['reply_message_id'] > 0): ?>
      <a href="view.php?id=<?php print(htmlspecialchars($post['reply_message_id'], ENT_QUOTES)); ?>">
      返信元のメッセージ</a>
    <?php endif; ?>

    <!-- 削除リンク -->
    <!-- if文でログインユーザ自身の投稿のみにリンクテキストを表示している -->
    <?php if ($_SESSION['id'] == $post['member_id']): ?>
    <!-- 投稿IDをパラメータで削除ページに渡している -->
    [<a href="delete.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>"
    style="color: #F33;">削除</a>]
    <?php endif; ?>
    </p>
    </div>
<?php endforeach; ?>
<ul class="paging">
<!-- 現在のページ数が1ページ目より大きければ「前のページ」へのリンクを貼り、そうでなければ表示しない -->
<?php if ($page > 1): ?>
<li><a href="index.php?page=<?php print($page - 1); ?>">前のページへ</a></li>
<?php else: ?>
<li>前のページへ</li>
<?php endif; ?>
<!-- 現在のページ数が最大ページ数より小さければ「次のページ」へのリンクを貼り、そうでなければ表示しない -->
<?php if ($page < $maxPage): ?>
<li><a href="index.php?page=<?php print($page + 1); ?>">次のページへ</a></li>
<?php else: ?>
<li>次のページへ</li>
<?php endif; ?>

</ul>
  </div>
</div>
</body>
</html>
