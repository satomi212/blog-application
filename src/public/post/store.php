<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/createBlogs.php');

$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST') appendError('post送信になっていません。');
if (empty($title)) appendError('タイトルを入力してください。');
if (empty($contents)) appendError('内容を入力してください。');
if (!empty($_SESSION['errors'])) redirect('create.php');

createBlogs($title, $contents);
redirect('../myPage.php');
?>


UPDATE
<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/updateBlogs.php');

$id = filter_input(INPUT_POST, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

updateBlogs($id, $title, $contents);
redirect('../myPage.php');
