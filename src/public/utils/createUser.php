<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function createUser(string $userName, string $mail, string $password): void
{
    $pdo = pdoInit();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = <<<EOF
    INSERT INTO
    users
    (name, email, password)
    VALUES
    (:userName, :mail, :password)
EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':userName', $userName, PDO::PARAM_STR);
    $statement->bindValue(':mail', $mail, PDO::PARAM_STR);
    $statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
    $statement->execute();
}
