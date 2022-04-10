<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function searchAndSortBlogs($searchWord): ?array
{
    $pdo = pdoInit();

    $sql = <<< EOF
    SELECT
    *
    FROM
    blogs
    WHERE
    contents
    LIKE
    :searchWord
    EOF;

    // ソート機能
    $sortMode = '';
    if (!empty($_GET['order'])) {
        $sortMode = filter_input(
            INPUT_GET,
            'order',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }

    if ($sortMode == 'asc' || $sortMode == 'desc') {
        $sql = $sql . " order by created_at $sortMode";
    }

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':searchWord', '%' . $searchWord . '%', PDO::PARAM_STR);
    $statement->execute();
    $blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
    return ($blogs) ? $blogs : null;
}
