<?php
session_start();
$message = $_SESSION['name'] ?? [];
unset($_SESSION['login']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一覧ページヘッダー</title>
</head>

<body>

    <header>
        <h3 class="headline">
            <a><?php echo "こんにちは" . $message . "さん"; ?></a>
        </h3>

        <h5 class="header-right">
            <a href="./index.php">一覧ページ</a>
            <a href="./mypage.php">マイページ</a>
            <a href="./user/signout.php">ログアウト</a>
        </h5>
    </header>

</body>
</html>
