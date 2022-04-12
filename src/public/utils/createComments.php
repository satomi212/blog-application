<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function createComments(string $commenter_name, string $comments): void
{
    $pdo = pdoInit();

    $sql = <<<EOF
INSERT INTO
comments
(user_id, blog_id, commenter_name, comments)
VALUES
(:user_id, :blog_id, :commenter_name, :comments)
EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
    $statement->bindValue(':blog_id', $_SESSION['blog_id'], PDO::PARAM_INT);
    $statement->bindValue(':commenter_name', $commenter_name, PDO::PARAM_STR);
    $statement->bindValue(':comments', $comments, PDO::PARAM_STR);

    if (null !== $commenter_name && null !== $comments) $statement->execute();
}
