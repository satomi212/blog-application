<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
// ↓エラ-メッセージを毎回消す
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事の新規作成</title>
</head>

<body>
    <div class="header">
        <h1>新規記事</h1>
    </div>

    <div class ="errors">
        <?php foreach ($errors as $error): ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>

    <form action="./store.php" method="post">
        <div class="title">
            <label for="title">タイトル</label>
            <br>
            <input type="text" name="title" id="title">
        </div>

        <div class="contents">
            <br>
            <label for="contents">内容</label>
            <br>
            <textarea name="contents" id="contents" cols="30" rows="5"></textarea>
        </div>

        <div class="button">
            <br>
            <button type="submit" name="submit">新規作成</button>
        </div>
    </form>

</body>
</html>
