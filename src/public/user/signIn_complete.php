<?php
require_once __DIR__ . '/../../app/Lib/pdoInit.php';
require_once __DIR__ . '/../../app/Lib/findUserByMail.php';
require_once __DIR__ . '/../../app/Lib/redirect.php';
// require_once __DIR__ . '/../../app/Lib/Session.php';
require_once './../../vendor/autoload.php';

use App\Lib\Session;

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
if (empty($mail) || empty($password)) {
    $session->appendError('パスワードとメールアドレスを入力してください');
    redirect('./signIn.php');
}

// mail取得
$users = findUserByMail($mail);
if (!password_verify($password, $users['password'])) {
    $session->appendError('メールアドレスまたはパスワードが違います');
    redirect('signIn.php');
}

$formInputs = [
    'userId' => $users['id'],
    'userName' => $users['name']
];
$session->setFormInputs($formInputs);
redirect('/../index.php');
?>
