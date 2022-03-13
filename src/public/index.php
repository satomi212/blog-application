<?php
session_start();
session_start();
$message = $_SESSION['name'] ?? [];
unset($_SESSION['login']);

//ログインされていない場合は強制的にログインページへ
if (!isset($_SESSION['id'])) {
    header('Location: ./user/signin.php');
    exit();
}

// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);

// 検索機能
$sql = "SELECT * FROM blogs WHERE contents LIKE '%" . $_POST['search'] . "%' ";

// ソート機能
$sortMode = '';
if (!empty($_GET['order'])) {
    $sortMode = filter_input(
        INPUT_GET,
        'order',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
}
if ($sortMode == 'asc' || $sortMode == 'desc') {
    $sql = $sql . "order by created_at $sortMode";
}

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
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>トップページ(一覧ページ)</title>
</head>

<body>
    <main>
    <header>

        <div class="w-full">
            <nav class="bg-white shadow-lg">
                <div class="md:flex items-center justify-between py-2 px-8 md:px-12">
                    <div class="flex justify-between items-center">
                        <div class="text-2xl font-bold text-gray-800 md:text-3xl">
                            Blogアプリ
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row hidden md:block -mx-2">
                        <a href="index.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ホーム</a>
                        <a href="myPage.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">マイページ</a>
                        <a href="./user/signout.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ログアウト</a>
                    </div>
                </div>
            </nav>
        </div>

    <h3 class="headline">
        <a><?php echo 'こんにちは' . $message . 'さん'; ?></a>
    </h3>
</header>


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
                    <form action="./detail.php?id=<?php echo $blog[
                        'id'
                    ]; ?>" method="post">
                        <button type="submit">記事詳細へ</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>
