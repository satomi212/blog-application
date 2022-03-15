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

// セッションidの発行
session_regenerate_id(true);

// セッションにログイン情報を登録
$_SESSION['blog_id'] = $blogs['id'];
