<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function selectComments(): ?array
{
    $pdo = pdoInit();

    $sql = <<< EOF
    SELECT
    *
    FROM
    comments
    WHERE blog_id = :id
EOF;

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_SESSION['blog_id'], PDO::PARAM_INT);
    $statement->execute();
    $commentList = $statement->fetchAll(PDO::FETCH_ASSOC);
    return ($commentList) ? $commentList : null;
}
