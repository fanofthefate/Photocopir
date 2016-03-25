<?php
/**
 * Created by PhpStorm.
 * User: Danusevich
 * Date: 12.12.2015
 * Time: 15:11
 */

if(isset($_COOKIE['path'])) {
    $path = unserialize($_COOKIE['path']);
    $id = str_replace('/', '', $_REQUEST['id']);
    if(isset($path[$id])){
        unset($path[$id]);
    }
    setcookie('path', serialize($path), time() + 3600 * 90, '/');
}