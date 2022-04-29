<?php
require_once __DIR__ . '/../../app/Lib/redirect.php';
require_once __DIR__ . '/../../app/Lib/pdoInit.php';

function deleteBlogs($id)
{
    $pdo = pdoInit();

    $sql = <<<EOF
DELETE
FROM
blogs
WHERE
id = :id;
EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}
