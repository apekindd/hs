<?php
include('functions/crop.php');
include('functions/resize_png.php');
include('functions/includeOnPng.php');

//$file=$_SERVER['DOCUMENT_ROOT'].'/data/ru/AT_001t.png';
$file_en=$_SERVER['DOCUMENT_ROOT'].'/data/translate/CS2_003en.png';
$file_ru=$_SERVER['DOCUMENT_ROOT'].'/data/translate/CS2_003ru.png';
$file_result=$_SERVER['DOCUMENT_ROOT'].'/data/translate/testru.png';
$file_dest=$_SERVER['DOCUMENT_ROOT'].'/data/translate/gibrid.png';

//CS2_003ru

//resizePng(200,303,$file, $file);

//cropPng($file,0,150,200,110,$_SERVER['DOCUMENT_ROOT'].'/data/translate/testru.png', 200, 303,150);

//crop ru, with ru text
cropPng($file_ru,0,150,200,110,$file_result, 200, 110,0);

//include one ru crop to en card
includeOnPng($file_result, $file_en, 200, 110, $file_dest, 200, 303, 150);