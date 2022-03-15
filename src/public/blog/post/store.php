<?php
// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);

session_start();

$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

// SQL
$sql =
    'INSERT INTO blogs (user_id, title, contents) VALUES (:user_id, :title, :contents)';
$statement = $pdo->prepare($sql);

// 受け取り
$statement->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$statement->bindValue(':title', $title, PDO::PARAM_STR);
$statement->bindValue(':contents', $contents, PDO::PARAM_STR);

// バリデーション
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $_SESSION['errors'][] = 'post送信になっていません。';
}
if (empty($title)) {
    $_SESSION['errors'][] = 'タイトルを入力してください。';
}
if (empty($contents)) {
    $_SESSION['errors'][] = '内容を入力してください。';
}

// 実行したらマイページに戻る
if (empty($_SESSION['errors'])) {
    $statement->execute();
    header('location: ../myPage.php');
} else {
    header('location: ./create.php');
    exit();
}

?>
