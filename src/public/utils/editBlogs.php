<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function editBlogs(int $id): ?array
{
    $pdo = pdoInit();

    $sql = <<<EOF
    SELECT
    *
    FROM
    blogs
    WHERE
    id = :id
    EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $statement->execute();
    $blogs = $statement->fetch(PDO::FETCH_ASSOC);
    return ($blogs) ? $blogs : null;
}
