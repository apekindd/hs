<?php
include('functions/crop.php');
include('functions/resize_png.php');

//$file=$_SERVER['DOCUMENT_ROOT'].'/data/ru/AT_001t.png';
$file=$_SERVER['DOCUMENT_ROOT'].'/data/ru/AT_001t.png';



resizePng(200,303,$file, $file);

cropPng($file,40,80,120,40,$_SERVER['DOCUMENT_ROOT'].'/data/ru/AT_001tt.png', 200, 40);