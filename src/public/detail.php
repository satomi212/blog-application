<?php
// DB接続
$db['user_name'] = "root";
$db['password'] = "password";
$pdo = new PDO("mysql:host=mysql; dbname=blog; charset=utf8", $db['user_name'], $db['password']);

session_start();

// 記事の取得
require('./selectArticle.php');

// コメントの登録
$commenter_name = filter_input(INPUT_POST, 'commenter_name');
$comments = filter_input(INPUT_POST, 'comments');

$sql = "INSERT INTO comments (user_id, blog_id, commenter_name, comments) VALUES (:user_id, :blog_id, :commenter_name, :comments)";
$statement = $pdo->prepare($sql);

$statement->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$statement->bindValue(':blog_id', $_SESSION['blog_id'], PDO::PARAM_INT);
$statement->bindValue(':commenter_name', $commenter_name, PDO::PARAM_STR);
$statement->bindValue(':comments', $comments, PDO::PARAM_STR);

// ニックネームと内容が書いてたら実行
if (null!== $commenter_name && $comments) {
    $statement->execute();
}

// コメントの表示
$sql = "SELECT * FROM comments WHERE blog_id = :id";
$statement = $pdo->prepare($sql);
$statement->bindValue('id', $_SESSION['blog_id'], PDO::PARAM_INT);
$statement->execute();
$commentList = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事の詳細ページ</title>
</head>

<body>
    <div id="main-top">

        <h1 class="title">
            <?php echo $blogs['title']; ?>
        </h1>

        <div class="created_at">
            <?php echo $blogs['created_at']; ?>
        </div>

        <div class="contents">
            <?php echo $blogs['contents']; ?>
        </div>

        <div class="button">
            <form action="../index.php">
                <button type="submit">一覧ページへ</button>
            </form>
        </div>
    </div>


    <div id="main-center">
        <h3 class="question">
            <a>この投稿にコメントしますか？</a>
        </h3>

        <div class="comment">
            <form action="../detail.php?id=<?php echo $_SESSION['blog_id']; ?>" method="post">
                <div class="comment-title">
                    <label for="commenter_name">ニックネーム</label>
                    <br>
                    <input type="text" name="commenter_name" id="commenter_name">
                </div>

                <div class="comment-contents">
                    <label for="comments">内容</label>
                    <br>
                    <textarea name="comments" id="comments" cols="30" rows="3"></textarea>
                </div>

                <div class="comment-button">
                    <button type="submit">コメント</button>
                </div>
            </form>
        </div>
    </div>


    <div id="main-bottom">
        <h3 class="comment-list">
            <a>コメント一覧</a>
        </h3>

        <div class="comment-list">
            <?php foreach($commentList as $comment): ?>
                <div class="comments">
                    <?php echo $comment['comments']; ?>
                </div>

                <div class="created_at">
                    <?php echo $comment['created_at']; ?>
                </div>

                <div class="commenter-name">
                    <?php echo $comment['commenter_name']; ?>
                </div>

                <div>
                    <a>-----------------------------------</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
