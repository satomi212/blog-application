<?php
require_once __DIR__ . '/../../app/Lib/redirect.php' ;

session_start();

//クッキーに登録されているセッションidの情報を削除
$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// セッションを破棄
session_destroy();
redirect('signIn.php');
?>
