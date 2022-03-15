<?php
// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);

// ブログ取得
$id = filter_input(INPUT_GET, 'id');
$sql = 'SELECT * FROM blogs WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);

// 編集機能
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事の詳細</title>
</head>
<body>

    <div id="main">
        <?php foreach ($blogs as $blog): ?>
            <h1 class="title">
                <a><?php echo $blog['title']; ?></a>
            </h1>

            <p class="created_at">
                <?php echo $blog['created_at']; ?>
            </p>

            <p class="contents">
                <?php echo $blog['contents']; ?>
            </p>
        <?php endforeach; ?>

        <!-- 編集ページ -->
        <form action="./edit.php?id=<?php echo $blog['id']; ?>" method="post">
            <button type="submit">編集</button>
        </form>

        <!-- 削除 -->
        <form action="./deleteBlogs.php?id=<?php echo $blog[
            'id'
        ]; ?>" method="post">
            <button type="submit">削除</button>
        </form>


        <!-- マイページ -->
        <form action="./myPage.php" method="post">
            <button type="submit">マイページへ</button>
        </form>
    </div>

</body>
</html>
