<?php
require_once __DIR__ . '/../../app/Lib/redirect.php';
require_once __DIR__ . '/../utils/updateBlogs.php';

$id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

updateBlogs($id, $title, $contents);
redirect('../myPage.php');
