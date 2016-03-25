<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function windows($string)
{
    return iconv("utf-8", "cp1251", $string);
}

function utf($string)
{
    return iconv("cp1251", "utf-8", $string);
}


include "partner_msg.php";
?>
