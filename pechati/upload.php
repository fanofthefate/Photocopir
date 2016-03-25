<?php

$result = [];
$uploaddir = dirname(__FILE__) . '/files/';

$allFiles = scandir($uploaddir);
$allFiles = array_diff($allFiles, array('.', '..'));
foreach ($allFiles as $oneFiles) {
    $filelastmodified = filemtime($uploaddir . $oneFiles);
    if ((time() - $filelastmodified) > 3600) {
        unlink($uploaddir . $oneFiles);
    }
}
if (!file_exists($uploaddir)) {
    mkdir($uploaddir);
}
$filePath = $uploaddir . $_FILES['qqfile']['name'];
if (move_uploaded_file($_FILES['qqfile']['tmp_name'], $filePath)) {
    $result['success'] = true;
    $result['path'] = true;

    $path[$_REQUEST['qquuid']] = $filePath;
    setcookie('path_'.$_REQUEST['qquuid'], $filePath, time() + 3600 * 90, '/');
} else {
    $result['success'] = false;
}
echo json_encode($result);
