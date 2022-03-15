<?php
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);

$id = filter_input(INPUT_GET, 'id');
$sql = 'DELETE FROM blogs WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
if ($statement->execute()) {
    header('location: ./myPage.php');
    exit();
}
