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
    <title>ログイン画面</title>
</head>
<body>

    <div id="main">
        <h1 class="title">
            <a>ログイン</a>
        </h1>

        <h3 class="message">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </h3>

        <form action="./completeSignin.php" method="post">
            <div>
                <input type="email" name="email" id="email" placeholder="Email">
            </div>

            <div>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>

            <div class="button">
                <button type="submit">ログイン</button>
            </div>
        </form>

        <a href="./signup.php">アカウントを作る</a>
    </div>

</body>
</html>
