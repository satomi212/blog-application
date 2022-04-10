<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/findUserByMail.php');
require_once(__DIR__ . '/../utils/redirect.php');

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

session_start();
if (empty($mail) || empty($password)) {
    appendError('パスワードとメールアドレスを入力してください');
    redirect('signin.php');
}

// mail取得
$user = findUserByMail($mail);
if (!password_verify($password, $user['password'])) {
    appendError('メールアドレスまたはパスワードが違います');
    redirect('signin.php');
}

$_SESSION['id'] = $user['id'];
$_SESSION['name'] = $user['name'];
redirect('/../index.php');
?>
