<?php
function pdoInit(): PDO
{
    $option = [
        //エミュレートモードをOFFにして、idをint型に
        PDO::ATTR_EMULATE_PREPARES=>false
    ];
    $dbUserName = 'root';
    $dbPassword = 'password';
    $pdo = new PDO('mysql:host=mysql; dbname=blog; charset=utf8', $dbUserName, $dbPassword, $option);
    // 例外エラーの詳細を出力
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
