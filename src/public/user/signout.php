<?php
session_start();

// ログインしてなかったらログインページへ
if (!isset($_SESSION["id"])) {
    header("Location: ./user/signin.php");
    exit();
}

$_SESSION = [];

//クッキーに登録されているセッションidの情報を削除
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// セッションを破棄
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウトページ</title>
</head>
<body>
    <p>ログアウトしました</p>
    <a href="./signin.php">ログインページへ</a>
</body>
</html>
