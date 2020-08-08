<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員情報変更</title>

	<link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>会員情報変更</h1>
</div> 

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
  

//エラー項目の確認
if(!empty($_POST)){
    if($_POST['name'] == ''){   //ブランクチェック
        $error['name'] = 'blank';
    }
    if($_POST['email'] == ''){   //ブランクチェック
        $error['email'] = 'blank';
    }
    //変更前パスワードチェック
    if(sha1($_POST['passwordBefore']) != $member['password']){   //パスワードマッチング
        $error['passwordBefore'] = 'unmatch';
    }
    if(strlen($_POST['passwordBefore']) < 4){   //文字数チェック
        $error['passwordBefore'] = 'length';
    }
    if($_POST['passwordBefore'] == ''){   //ブランクチェック
        $error['passwordBefore'] = 'blank';
    }
    //変更後パスワードチェック
    if(strlen($_POST['password']) < 4){   //文字数チェック
        $error['password'] = 'length';
    }
    if($_POST['password'] == ''){   //ブランクチェック
        $error['password'] = 'blank';
    }

    $fileName = $_FILES['image']['name'];
    if(!empty($fileName)){
        $ext = substr($fileName, -3);
        if($ext != 'jpg' && $ext != 'gif' && $ext != 'png'
        &&  $ext != 'JPG' && $ext != 'GIF' && $ext != 'PNG'){ //拡張子チェック
            $error['image'] = 'type';
        }
    }

	// アカウントの重複チェック
    if(empty($_error) && $_POST['email'] != $member['email']){
		// membersテーブルに登録されているメアドがフォームで入力したメアドと同じかをcountで数えて比較
		$memberCut = $db->prepare('SELECT COUNT(*) AS cut FROM members WHERE email=?');
		// プレースホルダーには入力したメアドをセット（WHERE条件に入る）
		$memberCut->execute(array($_POST['email']));
		// SELECT文でカウントされた結果をfetchで取り出してる
		$record = $memberCut->fetch();
		// カウント数が1以上なら重複（すでにDBに登録がある）ことになるのでエラー変数をセットしている
		if ($record['cut'] > 0) {
			$error['email'] = 'duplicate';
		}
	}


    //ここまででエラーが検出されなければ、
    //画像をアップロードする
    if(empty($error)){
        // 画像ファイルを選択していれば、選択された画像のファイル名をセッションにセット
        // ※type="file"のPOSTされる変数名は $_POST['image'] ではなかった
        // 　type="file" の場合は $_FILES にname属性のindex名を作って入るみたい
        if(!empty($_FILES['image']['name'])){
            $image = date('YmdHis'). $_FILES['image']['name']; //「yyyymmdd＋ファイル名」
            move_uploaded_file($_FILES['image']['tmp_name'], 'member_picture/'. $image);
            $_SESSION['join'] = $_POST;
            $_SESSION['join']['image'] = $image;
        //画像ファイルの選択がされてなければ、現在登録済の画像のファイル名をセッションにセット
        }else{
            $_SESSION['join'] = $_POST;
            $_SESSION['join']['image'] = $member['picture'];
        }
        //登録確認ページに飛ばしている
        header('Location: change_update.php');
        exit();
    }
}
//書き直し
//change_update.php画面から書き直しボタンを押した時にリンクのパラメータ値に'rewrite'を付加して送っているのでここに飛ぶ
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite'){
    //セッションの値をポストに書き戻している
    $_POST = $_SESSION['join'];
    //$errorが空だと画像再指定のエラーmsgが出ないのでダミーで$errorに値を入れているだけ
    $error['rewrite'] = true;
}
//↓サンプルではissetは使っていないが、これしないと各項目のindexがない入力欄（空で送信、エラーmsgが出ない）がエラーになる

//ファンクション：htmlspecialchars()
function h($value){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>
<div id="content">
<p>次のフォームに必要事項をご記入ください</p>
<form action="" method="post" enctype="multipart/form-data">
    <dl>
        <dt>ニックネーム<span class="required">　※必須</span></dt>
        <dd>
        <!-- 可読性比較：phpタグはできるだけまとめてみた -->
            <input type="text" name="name" size="35" maxlength="255"
            <?php if(isset($_POST['name'])){ //index名の有無確認のために追加 ?>
                value="<?php echo h($_POST['name']); ?>"/>
                <?php if(isset($error['name']) && $error['name'] == 'blank'){ ?>
                        <p class="error">* ニックネームを入力してください</p>
                <?php } ?>
            <?php }else{ ?>
                value="<?php echo h($member['name']); ?>"/>
            <?php } ?>
        </dd>

        <dt>メールアドレス<span class="required">　※必須</span></dt>
        <dd>
        <!-- 可読性比較：phpタグの部分は1行ごとにきっちり囲ってみた -->
            <input type="text" name="email" size="35" maxlength="255"
            <?php if(isset($_POST['email'])){ //index名の有無確認のために追加 ?>
                value="<?php echo h($_POST['email']); ?>"/>
                <?php if(isset($error['email'])){ //index名の有無確認のために追加 ?>
                    <?php if($error['email'] == 'blank'){ ?>
                        <p class="error">* メールアドレスを入力してください</p>
                    <?php } ?>
                    <?php if($error['email'] == 'duplicate'){ ?>
                        <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
                    <?php } ?>
                <?php } ?>
            <?php }else{ ?>
                value="<?php echo h($member['email']); ?>"/>
            <?php } ?>
        </dd>

        <dt>現在のパスワード<span class="required">　※必須</span></dt>
        <dd>
        <!-- 可読性比較：「if(): endif」文で書いてみた（{}の代わりにつける書き方） -->
            <input type="password" name="passwordBefore" size="10" maxlength="20"
            <?php if(isset($_POST['passwordBefore'])): //index名の有無確認のために追加 ?>
                value="<?php echo h($_POST['passwordBefore']); ?>"/>
                <?php if(isset($error['passwordBefore'])): //index名の有無確認のために追加 ?>
                    <?php if($error['passwordBefore'] == 'unmatch'): ?>
                        <p class="error">* パスワード不一致</p>
                    <?php endif; ?>
                    <?php if($error['passwordBefore'] == 'length'): ?>
                        <p class="error">* パスワードは4文字以上で入力してください</p>
                    <?php endif; ?>
                    <?php if($error['passwordBefore'] == 'blank'): ?>
                        <p class="error">* パスワードを入力してください</p>
                    <?php endif; ?>
                <?php endif ?>
            <?php else: ?>
                value=""/>
            <?php endif; ?>
        </dd>

        <dt>変更後のパスワード<span class="required">　※必須</span></dt>
        <dd>
        <!-- 可読性比較：「if(): endif」文で書いてみた（{}の代わりにつける書き方） -->
            <input type="password" name="password" size="10" maxlength="20"
            <?php if(isset($_POST['password'])): //index名の有無確認のために追加 ?>
                value="<?php echo h($_POST['password']); ?>"/>
                <?php if(isset($error['password'])): //index名の有無確認のために追加 ?>
                    <?php if($error['password'] == 'length'): ?>
                        <p class="error">* パスワードは4文字以上で入力してください</p>
                    <?php endif; ?>
                    <?php if($error['password'] == 'blank'): ?>
                        <p class="error">* パスワードを入力してください</p>
                    <?php endif; ?>
                <?php endif ?>
            <?php else: ?>
                value=""/>
            <?php endif; ?>
        </dd>

        <dt>写真など</dt>
        <dd>
        <!-- type="file"はvalue使えないみたいなので入力パスのキャッシュ表示は未実装（javaScript使えばできるかも） -->
            <input type="file" name="image" size="35" />
            <?php if(isset($error['image'])): //index名の有無確認のために追加 ?>
                <?php if($error['image'] == 'type'): ?>
                    <p class="error">* 写真などは「.gif」または「.jpg」の画像を指定してください</p>
                <?php endif; ?>
            <?php endif ?>
            <?php if(!empty($error)): ?>
                <p class="error">* 画像を改めて指定してください</p>
            <?php endif; ?>
        </dd>
    </dl>
    <div><input type="submit" value="入力内容を確認する"/></div>
</form>
<br>
<p><a href = "index.php">戻る</a></p>

</body>
</html>
