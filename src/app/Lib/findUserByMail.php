<?php
require_once __DIR__ . '/pdoInit.php';

function findUserByMail(string $mail): ?array
{
    $pdo = pdoInit();

    $sql = <<<EOF
SELECT
*
FROM
users
WHERE
email = :mail
EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':mail', $mail, PDO::PARAM_STR);
    $statement->execute();
    $users = $statement->fetch(PDO::FETCH_ASSOC);
    return ($users) ? $users : null;
}
