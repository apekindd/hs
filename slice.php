<?php
include('functions/crop.php');
include('functions/resize_png.php');

//$file=$_SERVER['DOCUMENT_ROOT'].'/data/ru/AT_001t.png';
$file=$_SERVER['DOCUMENT_ROOT'].'/data/ru/LOE_027.png';



resizePng(200,303,$file, $file);

//spell
//cropPng($file,40,80,120,40,$_SERVER['DOCUMENT_ROOT'].'/data/ru/AT_001nn'.time().'.png', 200, 40);
//all
cropPng($file,40,68,120,40,$_SERVER['DOCUMENT_ROOT'].'/data/ru/AT_001'.time().'.png', 200, 40);