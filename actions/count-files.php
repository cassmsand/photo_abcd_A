<?php
$blog_id = $_GET['blog_id'];
$directory = "../images/$blog_id";

if (is_dir($directory)) {
    $files = array_diff(scandir($directory), array('..', '.'));
    echo json_encode(array('fileCount' => count($files)));
} else {
    echo json_encode(array('fileCount' => 0));
}
?>