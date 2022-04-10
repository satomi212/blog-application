<?php
require_once(__DIR__ . '/utils/redirect.php');
require_once(__DIR__ . '/utils/selectBlogsByUser_id.php');

session_start();
//ログインされていない場合は強制的にログインページへ
if (!isset($_SESSION['id'])) redirect('user/signin.php');

$blogs = selectBlogsByUser_id();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>マイページ</title>
</head>
<body>
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
                        <?php $result = mb_substr(
                            $blog['contents'],
                            0,
                            $limit
                        ); ?>
                        <?php echo $result . '…'; ?>
                    <?php else: ?>
                        <?php echo $blog['contents']; ?>
                    <?php endif; ?>

                <div class="button">
                    <form action="./detail_myArticle.php?id=<?php echo $blog['id']; ?>" method="post">
                        <button type="submit">記事詳細へ</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

</body>
</html>
