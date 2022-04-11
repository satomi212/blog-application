<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function selectBlogsByUser_id(): ?array
{
    $pdo = pdoInit();

    $sql = <<<EOF
    SELECT
    *
    FROM
    blogs
    WHERE
    user_id = :id
EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
    $statement->execute();
    $blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
    return ($blogs) ? $blogs : null;
}
