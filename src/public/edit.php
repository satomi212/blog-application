<?php
// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);

$id = filter_input(INPUT_GET, 'id');
$sql = 'SELECT * FROM blogs WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$blogs = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ編集ページ</title>
</head>
<body>

    <form action="./update.php" method="post">
        <div class="id">
            <!-- hidden:ブラウザには表示されないがサーバには送信される -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars(
                $blogs['id'],
                ENT_QUOTES,
                'UTF-8'
            ); ?>">
        </div>

        <div class="title">
            <label for="title">タイトル</label>
            <br>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars(
                $blogs['title'],
                ENT_QUOTES,
                'UTF-8'
            ); ?>">
        </div>

        <div class="contents">
            <br>
            <label for="text">内容</label>
            <br>
            <input type="text" name="contents" id="contents" value="<?php echo htmlspecialchars(
                $blogs['contents'],
                ENT_QUOTES,
                'UTF-8'
            ); ?>">
        </div>

        <div class="button">
            <br>
            <button type="submit" name="submit">編集</button>
        </div>
    </form>


</body>
</html>
