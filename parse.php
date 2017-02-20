<?php
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/results/result.ser')){
    die('Файл с результатом уже существует.');
}

$allCardsPage = $_SERVER['DOCUMENT_ROOT'].'/data/cards/cards.html';
$allCardsPageContent = file_get_contents($allCardsPage);
preg_match_all("/http\:\/\/www\.allmmorpg\.ru\/card\/\?id\=(.*?)\"/",$allCardsPageContent,$out);
//$out[0] - links | $out[1] - ids
$arCards = [];
$i=0;
foreach ($out[0] as $k=>$link){
    $id = $out[1][$k];
    $l = str_replace('"','',$link);
    $content = file_get_contents($l);
    preg_match_all('#<b class="q">(.+?)</b>#is',$content,$name);
    preg_match_all('#<div>Класс:(.+?)</div>#is',$content,$class);
    preg_match_all('#<div>Тип:(.+?)</div>#is',$content,$type);
    preg_match_all('#<div>Набор:(.+?)</div>#is',$content,$pack);
    preg_match_all('#<div>Качество:(.+?)</div>#is',$content,$quality);
    preg_match_all('#<span class="hearthstone-cost" title="Цена">(.+?)</span>#is',$content,$cost);
    preg_match_all('#<span class="hearthstone-attack" title="Атака">(.+?)</span>#is',$content,$attack);
    preg_match_all('#<span class="hearthstone-health" title="Здоровье">(.+?)</span>#is',$content,$health);
    preg_match_all('#<span class="q2">(.+?)</span>#is',$content,$desc);
    preg_match_all('#<span class="q"><i>(.+?)</i></span>#is',$content,$history);
    preg_match_all("#src='//(.+?).png'>#is",$content,$simple);
    preg_match_all("#src='//(.+?).gif'>#is", $content,$golden);

    $arCards[$id]['name'] = trim($name[1][0]);
    $arCards[$id]['class'] = trim($class[1][0]);
    $arCards[$id]['type'] = trim($type[1][0]);
    $arCards[$id]['pack'] = trim($pack[1][0]);
    $arCards[$id]['quality'] = trim($quality[1][0]);
    $arCards[$id]['cost'] = trim($cost[1][0]);
    $arCards[$id]['attack'] = trim($attack[1][0]);
    $arCards[$id]['health'] = trim($health[1][0]);
    $arCards[$id]['description'] = trim($desc[1][0]);
    $arCards[$id]['history'] = trim($history[1][0]);
    $arCards[$id]['card']['simple'] = array_pop(explode("/",$simple[1][0])).".png";
    $arCards[$id]['card']['golden'] = array_pop(explode("/",$golden[1][0])).".gif";

    $i++;
}


$input = $_SERVER['DOCUMENT_ROOT']."/results/result.ser";
file_put_contents($input, serialize($arCards));

echo "Спарсено {$i}";