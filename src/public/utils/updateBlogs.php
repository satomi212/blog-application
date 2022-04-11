<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function updateBlogs(int $id, string $title, string $contents): void
{
    $pdo = pdoInit();

    $sql = <<<EOF
    UPDATE
    blogs
    SET
    title = :title, contents = :contents
    WHERE
    id = :id
EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
    $statement->execute();
}
