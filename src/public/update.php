<?php
// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);

$id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

$sql = 'UPDATE blogs SET title = :title, contents = :contents WHERE id = :id';
$statement = $pdo->prepare($sql);

$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->bindValue(':title', $title, PDO::PARAM_STR);
$statement->bindValue(':contents', $contents, PDO::PARAM_STR);

if ($statement->execute()) {
    header('location: ./myPage.php');
    exit();
}
