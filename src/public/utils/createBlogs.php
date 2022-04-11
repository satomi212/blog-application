<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function createBlogs(string $title, string $contents): void
{
    $pdo = pdoInit();

    $sql = <<<EOF
    INSERT INTO
    blogs
    (user_id, title, contents)
    VALUES
    (:user_id, :title, :contents)
EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
    $statement->execute();
}
