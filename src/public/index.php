<?php
session_start();

//ログインされていない場合は強制的にログインページへ
if (!isset($_SESSION["id"])) {
    header("Location: ./user/signin.php");
    exit();
}

// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO("mysql:host=mysql; dbname=blog; charset=utf8", $db['user_name'], $db['password']);

// 検索機能
$sql = "SELECT * FROM blogs WHERE contents LIKE '%".$_POST['search']."%' ";

// ソート機能
$sortMode = "";
if (!empty($_GET['order'])) $sortMode = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($sortMode == "asc" || $sortMode == "desc") $sql = $sql . "order by created_at $sortMode";

// 実行
$statement = $pdo->prepare($sql);
$statement->execute();
$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップページ(一覧ページ)</title>
</head>

<body>
    <header>
        <a><?php include('./header.php'); ?></a>
    </header>

    <main>
        <div class="title">
            <h1>blog一覧</h1>
        </div>

        <div class="search">
            <form action="./index.php" method="post">
                <input type="search" name="search" placeholder="キーワードを入力">
                <button type="submit" name="submit">検索</button>
            </form>
        </div>

        <div class="sort">
            <form action="./index.php?" method="get">
                <input type="hidden" name="order" value="asc">
                <button type="submit">新しい順</button>
            </form>

            <form action="./index.php?" method="get">
                <input type="hidden" name="order" value="desc">
                <button type="submit">古い順</button>
            </form>
        </div>


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
                    <form action="./detail.php?id=<?php echo $blog['id']; ?>" method="post">
                        <button type="submit">記事詳細へ</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>
