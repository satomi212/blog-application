<?php
require_once(__DIR__ . '/../utils/redirect.php');
session_start();

// ログインしてなかったらログインページへ
if (!isset($_SESSION['id'])) redirect('signIn.php');

//クッキーに登録されているセッションidの情報を削除
$_SESSION = [];
if (isset($_COOKIE[session_name()])) setcookie(session_name(), '', time() - 42000, '/');

// セッションを破棄
session_destroy();
redirect('signIn.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>ログアウトページ</title>
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
                    <a href="../index.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ホーム</a>
                    <a href="../myPage.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">マイページ</a>
                    <a href="./signOut.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ログアウト</a>
                </div>
            </div>
        </nav>
    </div>
</header>

</body>
</html>
