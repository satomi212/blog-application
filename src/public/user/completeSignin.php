<?php
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

session_start();
if (empty($email) || empty($password)) $_SESSION['errors'] = 'パスワードとメールアドレスを入力してください';

// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);

// Email取得
$sql = 'SELECT * FROM users WHERE email = :email';
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$users = $statement->fetch(PDO::FETCH_ASSOC);

if (!password_verify($password, $users['password'])) {
    $_SESSION['errors'] = 'メールアドレスまたはパスワードが違います';
    header('location: ./signin.php');
    exit();
}

$_SESSION['id'] = $users['id'];
$_SESSION['name'] = $users['name'];
header('location: ../index.php');
exit();
?>
