<?php
// 関数のvar_dumpは使ってるファイルでやる
// returnの後でvar_dumpしても意味ないよ！！
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/findUserByMail.php');
require_once(__DIR__ . '/../utils/createUser.php');
require_once(__DIR__ . '/../utils/session.php');

$mail = filter_input(INPUT_POST, 'mail');
$userName = filter_input(INPUT_POST, 'userName');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

session_start();
if (empty($password) || empty($confirmPassword)) appendError("パスワードを入力してください");
if ($password !== $confirmPassword) appendError("パスワードが一致しません");

if (!empty($_SESSION['errors'])) {
    $_SESSION['formInputs']['mail'] = $mail;
    $_SESSION['formInputs']['userName'] = $userName;
    redirect('signup.php');
}

// mailが一致するユーザーの取得
$user = findUserByMail($mail);
if (!is_null($user)) appendError("既に登録済みのメールアドレスです");
if (!empty($_SESSION['errors'])) redirect('signup.php');

// 会員情報の登録
createUser($userName, $mail, $password);
$_SESSION['registed'] = "登録できました。";
redirect('signIn.php');
?>
