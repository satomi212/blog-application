<?php
require_once __DIR__ . '/../app/Lib/redirect.php';
// require_once __DIR__ . '/../app/Lib/Session.php';
require_once __DIR__ . '/utils/searchAndSortBlogs.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Lib\Session;

$session = Session::getInstance();
// ログインされてなかったらログインページへ
if (!isset($_SESSION['formInputs']['userId'])) {
    redirect('./user/signIn.php');
}

// ヘッダーのメッセージ
$message = $_SESSION['name'] ?? [];

// 検索ワード
$searchWord = $_POST['search'];
$blogs = searchAndSortBlogs($searchWord);

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

    <?php include __DIR__ . '/../app/Lib/header.php'; ?>

        <div class="message">
            <h3 class="headline">
                <a><?php echo 'こんにちは' . $message . 'さん'; ?></a>
            </h3>
        </div>

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
