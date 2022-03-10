<?php
session_start();

//ログインされていない場合は強制的にログインページへ
if (!isset($_SESSION['id'])) {
    header("Location: ./user/signin.php");
    exit();
}

// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO("mysql:host=mysql; dbname=blog; charset=utf8", $db['user_name'], $db['password']);


// 記事取得
$sql = "SELECT * FROM blogs WHERE user_id = :id";

// 実行
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$statement->execute();
$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
</head>
<body>

    <header>
        <?php include('./header.php'); ?>
    </header>

    <main>
        <h1 class="title">
            <a>マイページ</a>
        </h1>

        <div class="button">
            <form action="./post/create.php" method="post">
                <button type="submit" name="submit">新規作成</button>
            </form>

            <div class="main">
                <?php foreach ($blogs as $blog): ?>
                    <?php echo $blog['title']; ?>
                    <?php echo $blog['created_at']; ?>

                    <!-- 15文字以降は...で表示 -->
                    <?php $limit = 15; ?>
                    <?php if (mb_strlen($blog['contents']) > $limit): ?>
                        <?php $result = mb_substr($blog['contents'], 0, $limit); ?>
                        <?php echo $result . '…'; ?>
                    <?php else: ?>
                        <?php echo $blog['contents']; ?>
                    <?php endif; ?>

                <div class="button">
                    <form action="./myArticleDetail.php?id=<?php echo $blog['id']; ?>" method="post">
                        <button type="submit">記事詳細へ</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

</body>
</html>
