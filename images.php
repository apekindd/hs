<?php
include('functions/resize_png.php');

$DIR = $_SERVER['DOCUMENT_ROOT'].'/data/cards/cards/png/';
$arFiles = scandir($DIR);

foreach ($arFiles as $file){
    if($file == '.' || $file == '..') continue;

    resizePng(200,303,$DIR.$file,$_SERVER['DOCUMENT_ROOT'].'/data/tests/'.$file);
}