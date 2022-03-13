<?php
session_start();

// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO("mysql:host=mysql; dbname=blog; charset=utf8", $db['user_name'], $db['password']);


// ポスト情報を変数へ
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$confirm = filter_input(INPUT_POST, 'confirm');


// Email取得
$sql = "SELECT * FROM users WHERE email = :email";
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$users = $statement->fetch(PDO::FETCH_ASSOC);


// 会員情報の登録
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$sql = 'INSERT INTO users (id, name, email, password) VALUES (0, :name, :email, :password)';
$statement = $pdo->prepare($sql);

$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->bindValue(":password", $hashedPassword, PDO::PARAM_STR);

// バリデーション
if (empty($name) || empty($email) || empty($password)) $_SESSION['errors'][] = "「ユーザー名」,「Email」,「パスワード」のどれかが入力されていません";

if ($password != $confirm) $_SESSION['errors'][] = 'パスワードが一致していません';

if ($email == $users['email']) {
    $_SESSION['errors'][] = "既に登録されているEmailです";
}


// エラーなかったらINSERT実行
if (!empty($_SESSION['errors'])) {
    header("location: ./signup.php");
    exit();
} else {
    $statement->execute();
    header("location: ./signin.php");
    exit();
}
?>
