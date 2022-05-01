<?php
require_once __DIR__ . '/../../app/Lib/pdoInit.php';
require_once __DIR__ . '/../../app/Lib/findUserByMail.php';
require_once __DIR__ . '/../../app/Lib/createUser.php';
require_once __DIR__ . '/../../app/Lib/redirect.php';
// require_once __DIR__ . '/../../app/Lib/Session.php';
require_once './../../vendor/autoload.php';

$mail = filter_input(INPUT_POST, 'mail');
$userName = filter_input(INPUT_POST, 'userName');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

use App\Lib\Session;

$session = Session::getInstance();
if (empty($password) || empty($confirmPassword)) {
    $session->appendError("パスワードを入力してください");
}
if ($password !== $confirmPassword) {
    $session->appendError("パスワードが一致しません");
}

if ($session->existsErrors()) {
    $formInputs = [
        'mail' => $mail,
        'userName' => $userName
    ];
    redirect('./signUp.php');
}

// mailが一致するユーザーの取得
$user = findUserByMail($mail);
if (!is_null($user)) {
    $session->appendError("既に登録済みのメールアドレスです");
}
if (!empty($_SESSION['errors'])) {
    redirect('./signUp.php');
}

// 会員情報の登録
createUser($userName, $mail, $password);
$succesRegistedMessage = "登録できました。";
$session->setMessage($succesRegistedMessage);
redirect('./signIn.php');
?>
