<?php
// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO("mysql:host=mysql; dbname=blog; charset=utf8", $db['user_name'], $db['password']);

session_start();

// Email取得
$email = filter_input(INPUT_POST, 'email');
$sql = "SELECT * FROM users WHERE email = :email";
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
// SELECT実行
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

// 同じメールアドレスが既に存在してたらバリデーション
foreach ($users as $user) {
    if ($email == $user['email']) {
        $_SESSION['errors'][] = "既に登録されているEmailです";
    }
}


// 会員情報の登録
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$confirm = filter_input(INPUT_POST, 'confirm');

$sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
$statement = $pdo->prepare($sql);

$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->bindValue(":password", password_hash($_POST['password'],
PASSWORD_DEFAULT), PDO::PARAM_STR);


// バリデーション
if (empty($name) || empty($email) || empty($password)) $_SESSION['errors'][] = "「ユーザー名」,「Email」,「パスワード」のどれかが入力されていません";

if ($password != $confirm) $_SESSION['errors'][] = 'パスワードが一致していません';

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
