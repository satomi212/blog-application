<?php
require_once(__DIR__ . '/utils/selectBlogsById.php');
require_once(__DIR__ . '/utils/createComments.php');
require_once(__DIR__ . '/utils/selectComments.php');

// 記事の取得
$id = filter_input(INPUT_GET, 'id');
$blogs = selectBlogsById($id);

session_start();
foreach ($blogs as $blog) {
    $_SESSION['blog_id'] = $blog['id'];
}

// コメントの登録
$commenter_name = filter_input(INPUT_POST, 'commenter_name');
$comments = filter_input(INPUT_POST, 'comments');
createComments($commenter_name, $comments);

// コメントの表示
$commentList = selectComments();
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
            <form action="../detail.php?id=<?php echo $_SESSION[
                'blog_id'
            ]; ?>" method="post">
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
            <?php foreach ($commentList as $comment): ?>
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
