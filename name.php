<?php
//header('Content-Type: text/html; charset=windows-1251');

$ser = $_SERVER['DOCUMENT_ROOT']."/results/result_en.ser";
$arCards = file_get_contents($ser);
$arCards = unserialize($arCards);

$i=0;
foreach ($arCards as $k=>$arCard){
    if($arCard['name_en'] != ''){
        continue;
    }
    $card = $arCard['name'];
    $card = str_replace("\\","",$card);
    $card = preg_replace('#"(.*?)"#', '«$1»', $card);

    $str = urlencode("hearthstone.buffed.de ".$card);
    //$content = file_get_contents("https://www.google.com.ua/search?espv=2&q={$str}");
    $content = file_get_contents("https://nova.rambler.ru/search?scroll=1&utm_source=nhp&utm_content=search&utm_medium=button&utm_campaign=self_promo&query={$str}");

    $content = str_replace(["<b>","</b>"],'',$content);
    $card = explode("'",$card);
    //$card = iconv("utf-8","windows-1251",$card[count($card)-1]);
    $card = $card[count($card)-1];
    //preg_match_all("#{$card} \((.+?)\)#is",$content,$name);
    preg_match_all("#{$card} / (.+?) -#is",$content,$name);

    $arCards[$k]['name_en'] = $name[1][0];
    sleep(1);
   // echo '<pre>';print_r($name); echo '</pre>';
    if($i==22){
       break;
    }
    $i++;
}
die();
$input = $_SERVER['DOCUMENT_ROOT']."/results/result_en.ser";
file_put_contents($input, serialize($arCards));

echo "$i";
