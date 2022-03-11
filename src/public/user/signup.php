<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録ページ</title>
</head>
<body>

    <div id="main">
        <h1 class="title">
            <a>会員登録</a>
        </h1>

        <!-- エラー表示 -->
        <div class="message">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>

        <form action="./completeSignup.php" method="post">
            <div class="mail">
                <input type="text" name="name" id="name" placeholder="User name">
            </div>

            <div class="email">
                <input type="email" name="email" id="email" placeholder="Email">
            </div>

            <div class="password">
                <input type="password" name="password" id="password" placeholder="Password">
            </div>

            <div class="confirm">
                <input type="password" name="confirm" id="confirm" placeholder="パスワード認証">
            </div>

            <div class="button">
                <button type="submit">アカウント作成</button>
            </div>
        </form>

        <div>
            <a href="./signin.php">ログイン画面へ</a>
        </div>
    </div>

</body>
</html>
