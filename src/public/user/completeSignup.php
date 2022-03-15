<?php
// セッションへ格納
session_start();
$_SESSION['email'] = filter_input(INPUT_POST, 'email');;
$_SESSION['name'] = filter_input(INPUT_POST, 'name');


// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);


// ポスト情報を変数へ
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$confirm = filter_input(INPUT_POST, 'confirm');


if (empty($password) || empty($confirm)) $_SESSION['errors'][] = 'パスワードを入力してください';

if ($password != $confirm) $_SESSION['errors'][] = 'パスワードが一致していません';

if (!empty($_SESSION['errors'])) {
    header('location: ./signup.php');
    exit();
}


// Email取得
$sql = 'SELECT * FROM users WHERE email = :email';
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$users = $statement->fetch();

$available = (!$users) ? true : false;
if (!$available) $_SESSION['errors'][] = '既に登録されているEmailです';

if (!empty($_SESSION['errors'])) {
    header('location: ./signup.php');
    exit();
}


// 会員情報の登録
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$sql =
    'INSERT INTO users (id, name, email, password) VALUES (0, :name, :email, :password)';
$statement = $pdo->prepare($sql);

$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
$statement->execute();

$_SESSION['registed'] = "登録できました";
header('location: ./signin.php');
exit();
?>
